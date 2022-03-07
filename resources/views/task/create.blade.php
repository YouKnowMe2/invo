<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Task') }}
            </h2>
            <a href="{{ route('task.index') }}" class="bg-gray-800 px-4 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(count($clients) == 0)
                        <div class="bg-red-600 text-center text-white p-2">
                            <p class="my-2">
                                You don't have any client
                            </p>
                            <p>
                                Add new client <a class="bg-black p-1 rounded-xl" href="{{route('client.create')}}">Click here</a>
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-6 flex">

                            <div class="flex-1 mr-4">
                                <label for="name" class="formLabel">Name</label>
                                <input type="text" name="name" id="name" class="formInput" required value="{{ old('name') }}">

                                @error('name')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="flex-1 mr-4">
                                <label for="slug" class="formLabel">slug</label>
                                <input type="text" name="slug" id="slug" class="formInput" required value="{{ old('slug') }}">

                                @error('slug')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>



                        <div class="mt-6 flex">
                            <div class="flex-1 mr-4">
                                <label for="price" class="formLabel">Price</label>
                                <input type="number" name="price" id="price" required class="formInput" value="{{ old('price') }}">
                                @error('price')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 mr-4">
                                <label for="client_id" class="formLabel">Client</label>


                                <select name="client_id" id="client_id" class="formInput">
                                    <option value="none">Select Client</option>
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}" {{$client->id == old('client_id') ? 'selected' : '' }}>{{$client->name}}</option>
                                    @endforeach
                                </select>


                                @error('client_id')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                        <div class="mt-6 flex justify-between">



                                <div class="flex-1 mr-4 ml-0">
                                    <label for="description" class="formLabel">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="formInput">{{old('description')}}</textarea>
                                    @error('username')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>




                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="px-4 py-2 text-base uppercase bg-emerald-800 text-white rounded-md">Create</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $('#description').summernote({

                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        </script>
    @endsection
</x-app-layout>
