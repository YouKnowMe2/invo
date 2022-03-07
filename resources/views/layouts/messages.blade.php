@if(Session('success'))

    <div class="bg-red-300 text-center" id="status_message">
        <p class="p-2 text-xl font-bold">{{Session('success')}}</p>
    </div>

@endif
