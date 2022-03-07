<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cilents') }}
            </h2>

            <div class="min-w-max">
                <a href="{{route('task.create')}}" class="bg-gray-800 px-4 py-2 text-white">Add New Task</a>
            </div>
        </div>

    </x-slot>

   @include('layouts.messages')

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form action="{{ route('task.index') }}" method="GET">


                        <div class="mt-6 flex {{request('client_id') || request('price') || request('status') ? '' :'hidden'}}" id="taskFilter">



                            <div class="p-4 inline-block text-center ">
                                <label for="client_id" class="formLabel">Client</label>
                                <select name="client_id" id="client_id" class="formInput">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" {{$client->id == old('client_id') || $client->id == request('client_id')  ? 'selected' : '' }}>{{$client->name}}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>




                            <div class="p-4 inline-block">
                                <label for="status" class="formLabel">Status</label>
                                <select name="status" id="status" class="formInput">
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ old('status')== 'pending' || request('status')== 'pending' ? 'selected' : '' }} >Pending</option>
                                    <option value="complete" {{ old('status')== 'complete' || request('status')== 'complete' ? 'selected' : '' }}>Complete</option>

                                </select>

                                @error('status')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>



                            <div class="p-4 inline-block">
                                <label for="price" class="formLabel">Price</label>
                                <input type="number" name="price" id="price" value="{{ request('price') }}">
                                @error('price')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror


                            </div>

                            <div class="p-4 mt-6 inline-block">
                                <button type="submit" class="px-4 py-2 text-base uppercase bg-emerald-800 text-white rounded-md ">Filter</button>
                                <a href="{{route('task.index')}}" class="px-4 py-2 text-base uppercase bg-emerald-800 text-white rounded-md">Reset</a>
                            </div>


                        </div>


                    </form>

                    <div class="text-right my-7">
                        <button id="taskFilterBtn" type="submit" class="px-4 py-2 mr-5 bg-blue-700 text-white" >{{request('client_id') || request('price') || request('status') ? 'Close' :'Filter'}}</button>
                    </div>


                    <table class="w-full table-auto mb-6">
                        <thead>
                        <tr>
                            <th class="border px-4 py-2">Select</th>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Price</th>
                            <th class="border px-4 py-2">Description</th>
                            <th class="border px-4 py-2">Client</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Action</th>


                        </tr>
                        </thead>
                        <tbody>

                        <form action="{{route('invoice.generate')}}" method="GET">
                            @csrf

                        @foreach($tasks as $task)
                            <tr>
                                <td class="border px-4 py-2">
                                    <input type="checkbox" name="invoice_ids[]" value="{{$task->id}}" checked>
                                </td>
                                <td class="border px-4 py-2">{{$task->name}}</td>
                                <td class="border px-4 py-2">{{$task->price}}</td>
                                <td class="border px-4 py-2">  {!! $task->description !!}} </td>
                                <td class="border px-4 py-2"><a class="text-lime-700" href="{{route('client.show',$task->client)}}">{{$task->client->name }}</a></td>
                                <td class="border px-4 py-2 capitalize ">{{$task->status }}</td>
                                <td class="border px-4 py-2 flex">
                                    <a class="bg-emerald-600 text-white px-4 py-2 mx-2 text-xs rounded" href="{{route('task.edit',$task->id)}}">Edit</a> <a class="bg-sky-600 text-white px-4 py-2 mx-2 text-xs rounded" href="{{route('task.show',$task->id)}}">View</a>
                                    <form action="{{route('task.destroy',$task->id)}}" method="POST" onsubmit="return confirm('Do you want to delete task?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-700 text-white px-4 py-2 text-xs rounded">Delete</button>

                                    </form>


                                </td>



                            </tr>
                        @endforeach
                            <tr>
                            <button type="submit"> Submit</button>

                            </tr>
                        </form>
                        </tbody>
                    </table>

                    {{$tasks->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

