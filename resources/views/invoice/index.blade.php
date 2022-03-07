<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice') }}
            </h2>

            <div class="min-w-max">
                <a href="{{route('invoice.create')}}" class="bg-gray-800 px-4 py-2 text-white">Search Invoice by Client</a>
            </div>
        </div>

    </x-slot>

  @include('layouts.messages')

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(count($invoices)>0)
                    <table class="w-full table-auto mb-6 text-center items-center capitalize">
                        <thead>
                        <tr>
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Client</th>
                            <th class="border px-4 py-2">Download Url</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Email Sent</th>
                            <th class="border px-4 py-2">Action</th>


                        </tr>
                        </thead>
                        <tbody>


                        @foreach($invoices as $invoice)
                            <tr class="">

                                <td class="border px-4 py-2">{{$invoice->invoice_id}}</td>
                                <td class="border px-4 py-2">{{$invoice->client->name}}</td>
                                <td class="border px-4 py-2">
                                    <a  class="bg-purple-600 text-white px-4 py-2 mx-2 text-xs rounded"
                                        href="{{ route('invoice.download')}}{{'?client_id='.$invoice->client->id.'&status='.'complete' }}">Download Invoice
                                    </a>
                                    <a  class="bg-blue-600 text-white px-4 py-2 mx-2 text-xs rounded"
                                        href="{{ route('invoice.preview')}}{{'?client_id='.$invoice->client->id.'&status='.'complete' }}">Preview Invoice
                                    </a>
                                </td>
                                <td class="border px-4 py-2">  {{ $invoice->status }} </td>
                                <td class="border px-4 py-2">  {{ $invoice->email_sent }} </td>
                                <td class="border px-4 py-2 flex justify-center items-center">
{{--                                    <a class="bg-sky-600 text-white px-4 py-2 mx-2 text-xs rounded" href="{{route('invoice.show',$invoice->id)}}">Edit</a>--}}
                                    @if($invoice->status == 'unpaid')
                                        <form action="{{route('invoice.status',$invoice)}}" method="POST"  onsubmit="return confirm('Did you Paid for this?')" class="bg-emerald-600 text-white px-4 py-2 text-xs rounded mx-2">@csrf @method('PUT')
                                            <button type="submit">Paid</button>
                                        </form>
                                    @endif
                                    <form action="{{route('invoice.sendMail',$invoice)}}" method="POST" onsubmit="return confirm('Do you want to Send invoice?')">
                                        @csrf
                                        <button type="submit" class="bg-sky-600 text-white px-4 py-2 text-xs rounded mx-2">Send Mail</button>

                                    </form>
                                    <form action="{{route('invoice.destroy',$invoice->id)}}" method="POST" onsubmit="return confirm('Do you want to delete invoice?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-700 text-white px-4 py-2 text-xs rounded">Delete</button>

                                    </form>

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <h1 class="font-bold text-center text-3xl">No invoices Found</h1>
                    @endif

                    {{$invoices->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

