<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cilents') }}
            </h2>

            <div class="min-w-max">
                <a href="{{route('client.create')}}" class="bg-gray-800 px-4 py-2 text-white">Add New Client</a>
            </div>
        </div>

    </x-slot>

    @include('layouts.messages');

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full table-auto mb-6 text-center">
                        <thead>
                        <tr>
                            <th class="border px-4 py-2">thumbnail</th>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">username</th>
                            <th class="border px-4 py-2">email</th>
                            <th class="border px-4 py-2">phone</th>
                            <th class="border px-4 py-2">country</th>
                            <th class="border px-4 py-2">Task count</th>
                            <th class="border px-4 py-2">status</th>
                            <th class="border px-4 py-2">Action</th>
                            <th class="border px-4 py-2"></th>

                        </tr>
                        </thead>
                        <tbody>

                        @php
                            function getImageUrl($image){
                                    if(str_starts_with($image,'http')){
                                        return $image;
                                    }else{
                                        return '/storage/uploads/' . $image;
                                    }
                            }
                        @endphp



                        @foreach($clients as $client)
                            <tr>
                                <td class="border px-4 py-2"><img  width="50" class="rounded-xl" src="{{getImageUrl($client->thumbnail)}}"/></td>
                                <td class="border px-4 py-2">{{$client->name}}</td>
                                <td class="border px-4 py-2">{{$client->username}}</td>
                                <td class="border px-4 py-2">{{$client->email}}</td>
                                <td class="border px-4 py-2">{{$client->phone}}</td>
                                <td class="border px-4 py-2">{{$client->country}}</td>
                                <td class="border px-4 py-2">
                                    @if(count($client->tasks) > 0 )
                                    <a href="{{route('client.show',$client->id)}}">{{count($client->tasks)}}</a>
                                    @else
                                        {{count($client->tasks)}}
                                    @endif
                                </td>
                                <td class="border px-4 py-2">{{$client->status}}</td>
                                <td class="border px-4 py-2 flex">
                                    <a class="bg-emerald-600 text-white px-4 py-2 mx-2 text-xs rounded" href="{{route('client.edit',$client->id)}}">Edit</a>
                                    <form action="{{route('client.destroy',$client->id)}}" method="POST" onsubmit="return confirm('Do you want to delete client?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-700 text-white px-4 py-2 text-xs rounded">Delete</button>

                                    </form>


                                </td>



                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{$clients->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

