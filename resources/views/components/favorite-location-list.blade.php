<div class="mt-4 space-y-4">
    @if($locations->isEmpty())
        <div class="text-center py-4 text-gray-500">
            ❌ Belum ada lokasi favorit.
        </div>
    @else
        @foreach($locations as $location)
            <a href="{{ route('weather.index', ['location' => $location->city]) }}" class="block group">
                <div class="relative card bg-gradient-to-br from-blue-200 to-gray-200 shadow-md rounded-lg p-4 transition duration-300 transform group-hover:scale-105 group-hover:shadow-xl overflow-hidden">
                    <!-- Overlay Efek Hover -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 transition duration-300 group-hover:bg-opacity-10"></div>

                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-800 transition">{{ $location->name }}</h3>
                            <p class="text-gray-600 group-hover:text-gray-900">{{ $location->city }}, {{ $location->country }}</p>
                            <p class="text-sm text-gray-500 group-hover:text-gray-700">{{ $location->notes }}</p>
                        </div>

                        <div class="flex space-x-2">
                            <!-- Edit Button -->
                            <button onclick="event.preventDefault(); openEditModal('{{ $location->id }}')" class="tooltip tooltip-left text-blue-500 hover:text-blue-700 z-20 relative" data-tip="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>

                            <!-- Delete Button -->
                            <button onclick="event.preventDefault(); openDeleteModal('{{ $location->id }}')" class="tooltip tooltip-left text-red-500 hover:text-red-700 z-20 relative" data-tip="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Edit Modal -->
            <dialog id="edit-modal-{{ $location->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Edit Lokasi</h3>
                    <form action="{{ route('favorite-locations.update', $location->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')

                        <div class="space-y-3">
                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Nama</span>
                                <input type="text" name="name" value="{{ $location->name }}" class="input input-bordered w-full mt-1">
                            </label>

                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Kota</span>
                                <input type="text" name="city" value="{{ $location->city }}" class="input input-bordered w-full mt-1">
                            </label>

                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Negara</span>
                                <input type="text" name="country" value="{{ $location->country }}" class="input input-bordered w-full mt-1">
                            </label>

                            <div class="grid grid-cols-2 gap-4">
                                <label>
                                    <span class="text-sm font-medium text-gray-700">Latitude</span>
                                    <input type="number" step="any" name="latitude" value="{{ $location->latitude }}" class="input input-bordered w-full mt-1">
                                </label>
                                <label>
                                    <span class="text-sm font-medium text-gray-700">Longitude</span>
                                    <input type="number" step="any" name="longitude" value="{{ $location->longitude }}" class="input input-bordered w-full mt-1">
                                </label>
                            </div>

                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Catatan</span>
                                <textarea name="notes" rows="2" class="textarea textarea-bordered w-full mt-1">{{ $location->notes }}</textarea>
                            </label>

                            <div class="flex justify-end space-x-2">
                                <button type="button" onclick="closeEditModal('{{ $location->id }}')" class="btn btn-ghost">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- Delete Modal -->
            <dialog id="delete-modal-{{ $location->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Hapus Lokasi</h3>
                    <p>Apakah Anda yakin ingin menghapus lokasi favorit ini?</p>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" onclick="closeDeleteModal('{{ $location->id }}')" class="btn btn-ghost">Batal</button>
                        <form action="{{ route('favorite-locations.destroy', $location) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn bg-red-500 text-white">Hapus</button>
                        </form>
                    </div>
                </div>
            </dialog>
        @endforeach
    @endif
</div>

<script>
    function openEditModal(id) {
        document.getElementById(`edit-modal-${id}`).showModal();
    }

    function closeEditModal(id) {
        document.getElementById(`edit-modal-${id}`).close();
    }

    function openDeleteModal(id) {
        document.getElementById(`delete-modal-${id}`).showModal();
    }

    function closeDeleteModal(id) {
        document.getElementById(`delete-modal-${id}`).close();
    }
</script>
