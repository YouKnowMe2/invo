<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Task Info') }}
            </h2>

            <div class="min-w-max">
                <a href="{{route('task.index')}}" class="bg-gray-800 px-4 py-2 text-white">Back</a>
            </div>
        </div>

    </x-slot>

    @if(Session('success'))

        <div class="bg-red-300 text-center" id="status_message">
            <p class="p-2 text-xl font-bold">{{Session('success')}}</p>
        </div>

    @endif

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex-1">
                        <div class="flex items-center justify-center my-4 ">
                            <h1 class="font-bold text-3xl">Task Name-{{$task->name}}</h1>

                        </div>
                        <div class="flex items-center justify-center text-xl ">
                           Description:</br>
                           {!! $task->description !!}}
                        </div>
                        <div class="flex items-start justify-end  my-4 mr-32 ">
                            <h1 class="font-bold">Price: ${{$task->price}}</h1>

                        </div>
                        <div class="flex items-start justify-start  my-4 ml-32 ">
                            <h1 class="font-bold">Name: {{$task->client->name}}</h1>

                        </div>
                        <div class="flex items-start justify-start my-4 ml-32 ">
                            <p class="capitalize">Status: {{$task->status}}</p>

                        </div>
                        <div class="flex items-start justify-start my-4 ml-32 ">
                            @if($task->status == 'pending')
                            <form action="{{route('status',$task)}}" method="POST" class="capitalize bg-red-500 px-2 py-2">@csrf @method('PUT')
                                <button type="submit">Mark As Done</button>
                            </form>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

