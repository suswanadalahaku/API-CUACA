<div class="w-1/4 bg-gray-800 text-white h-auto px-4 pt-20">
  <div class="form-control">
      <form id="search-box" class="flex justify-between mb-4" method="GET" action="{{ route('weather.index') }}">
          <input type="text" name="location" placeholder="Search..." id="location-input" class="w-full p-2 border rounded-md text-gray-800 bg-gray-200">
          <button type="submit" class="ml-2 p-2 bg-teal-500 text-white rounded-md">🔍</button>
      </form>
  </div>
  <ul>
    <li><a href="{{ route('show.add.location') }}" class="block p-4 hover:bg-base-200 {{ request()->routeIs('show.add.location') ? 'bg-base-200' : '' }}">Tambahkan Lokasi Favorit</a></li>
    @include('components.favorite-location-list', ['locations' => $locations ?? collect()])

  </ul>
</div>