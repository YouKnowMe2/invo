<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Invoice') }}
            </h2>
            <a href="{{ route('invoice.index') }}" class="bg-gray-800 px-4 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form action="{{ route('invoice.search') }}" method="GET">
                        @csrf

                        <div class="mt-6 flex">

                            <div class="flex-1 mr-4">
                                <label for="client_id" class="formLabel">Client</label>
                                 <select name="client_id" id="client_id" class="formInput">
                                    <option value="none">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" {{$client->id == old('client_id') || $client->id == request('client_id')  ? 'selected' : '' }}>{{$client->name}}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="flex-1 mr-4">
                                <label for="status" class="formLabel">Status</label>
                                <select name="status" id="status" class="formInput">
                                    <option value="none">Select Status</option>
                                    <option value="pending" {{ old('status')== 'pending' || request('status')== 'pending' ? 'selected' : '' }} >Pending</option>
                                    <option value="complete" {{ old('status')== 'complete' || request('status')== 'complete' ? 'selected' : '' }}>Complete</option>

                                </select>

                                @error('status')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                            <div class="mt-6">
                                <button type="submit"
                                        class="px-4 py-2 text-base uppercase bg-emerald-800 text-white rounded-md">Show</button>
                            </div>
                    </form>
                <div class="py-8">
                   @include('layouts.messages')
                </div>

                </div>
            </div>
        </div>
    </div>



                    @if(!empty($tasks) && count($tasks) != 0 )
                <div class="py-2">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-2 bg-white border-b border-gray-200">

                        <table class="w-full table-auto mb-6">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Price</th>
                                <th class="border px-4 py-2">Description</th>
                                <th class="border px-4 py-2">Client</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Action</th>


                            </tr>
                            </thead>
                            <tbody>


                            @foreach($tasks as $task)
                                <tr>
                                    <td class="border px-4 py-2">{{$task->id}}</td>
                                    <td class="border px-4 py-2">{{$task->name}}</td>
                                    <td class="border px-4 py-2">{{$task->price}}</td>
                                    <td class="border px-4 py-2">  {!! $task->description !!}} </td>
                                    <td class="border px-4 py-2"><a class="text-lime-700" href="{{route('client.show',$task->client)}}">{{$task->client->name }}</a></td>
                                    <td class="border px-4 py-2 capitalize ">{{$task->status }}</td>
                                    <td class="border px-4 py-2 flex mt-12">
                                        <a class="bg-emerald-600 text-white px-4 py-2 mx-2 text-xs rounded" href="{{route('task.edit',$task->id)}}">Edit</a> <a class="bg-sky-600 text-white px-4 py-2 mx-2 text-xs rounded" href="{{route('task.show',$task->id)}}">View</a>
                                        <form action="{{route('task.destroy',$task->id)}}" method="POST" onsubmit="return confirm('Do you want to delete task?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-700 text-white px-4 py-2 text-xs rounded">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            </div>


                                <div class="flex items-center justify-center mb-12">
                                    @if(request('status') == 'complete')

                                        <a href="{{route('invoice.generate')}}{{'?client_id='.request('client_id').'&status='.request('status') }}
                                        "class="bg-green-600 text-white p-2 text-center">Generate</a>
                                    @endif

                                </div>
                                @endif
            </div>
        </div>
    </div>


</x-app-layout>
