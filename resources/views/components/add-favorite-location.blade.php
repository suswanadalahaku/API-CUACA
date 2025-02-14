<div class=" mt-8 max-w-3xl mx-auto">
    <div class="bg-gradient-to-br from-gray-200 to-blue-200 rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Add Favorite Location</h2>
            
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
                <div class="bg-green-50 text-green-500 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Add Location Form -->
            <form action="{{ route('favorite-locations.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" class="bg-gray-200 text-gray-800 p-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 mb-2">City</label>
                        <input type="text" name="city" class="bg-gray-200 text-gray-800 p-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 mb-2">Country</label>
                        <input type="text" name="country" class="bg-gray-200 text-gray-800 p-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 mb-2">Latitude</label>
                        <input type="number" step="any" name="latitude" class="bg-gray-200 text-gray-800 p-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 mb-2">Longitude</label>
                        <input type="number" step="any" name="longitude" class="bg-gray-200 text-gray-800 p-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <input type="text" name="notes" class="bg-gray-200 text-gray-800 p-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-teal-500 text-white px-6 py-3 rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all">
                        Add Location
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
