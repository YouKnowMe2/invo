<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{$client->name }}
                <p class="font-light"> {{$client->email}}</p>
                <p class="font-light"> {{$client->phone}}</p>
            </h2>


            <div class="min-w-max">
                <a href="{{route('client.index')}}" class="bg-gray-800 px-4 py-2 text-white">Back</a>
            </div>
        </div>

    </x-slot>

  @include('layouts.messages')

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full table-auto mb-6">
                        <thead>
                        <tr>
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Price</th>
                            <th class="border px-4 py-2">Description</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Price</th>
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
                                <td class="border px-4 py-2 capitalize ">{{$task->status }}</td>
                                <td class="border px-4 py-2 capitalize">{{$task->price}}</td>
                                <td class="border px-4 py-2 flex">
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
            </div>
        </div>
    </div>
</x-app-layout>

