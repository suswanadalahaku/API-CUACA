<div>
<!-- <div class="weather-component" data-weather-loaded="{{ isset($weather) ? 'true' : 'false' }}"> -->
    @if(isset($weather))
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg p-6 mx-auto max-w-5xl">
            <!-- Location Header -->
            <div class="mb-6 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $weather['location_name'] }}</h2>
                <div class="flex justify-center items-center space-x-4 text-gray-600">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ number_format($weather['latitude'], 6) }}°N
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ number_format($weather['longitude'], 6) }}°E
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Current Weather -->
                <div class="bg-white rounded-lg shadow-md p-6 transform hover:scale-105 transition-transform duration-300 hover:shadow-xl">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Current Weather</h3>
                    <div class="flex flex-col items-center">
                    <img src="{{ asset('assets/' . $weather['current']['weather_condition']['icons']) }}" 
                            alt="weather-icon" 
                            class="w-32 h-32 mb-4 filter drop-shadow-lg"
                        />
                        <p class="text-5xl font-bold text-gray-800 mb-2">{{ $weather['current']['temperature_2m'] }}°C</p>
                        <p class="text-lg text-gray-600">{{ $weather['current']['weather_condition']['name'] }}</p>
                    </div>
                </div>

                <!-- Weather Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Weather Details</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 flex items-center space-x-3 transform hover:scale-105 transition-transform duration-300 hover:shadow-lg">
                            <img src="{{ asset('assets/humidity.svg') }}" alt="humidity" class="w-8 h-8"/>
                            <div>
                                <p class="text-sm text-gray-500">Humidity</p>
                                <p class="text-lg font-semibold">{{ $weather['current']['relative_humidity_2m'] }}%</p>
                            </div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4 flex items-center space-x-3 transform hover:scale-105 transition-transform duration-300 hover:shadow-lg">
                            <img src="{{ asset('assets/wind.svg') }}" alt="wind-speed" class="w-8 h-8"/>
                            <div>
                                <p class="text-sm text-gray-500">Wind Speed</p>
                                <p class="text-lg font-semibold">{{ $weather['current']['wind_speed_10m'] }} km/h</p>
                            </div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4 flex items-center space-x-3 transform hover:scale-105 transition-transform duration-300 hover:shadow-lg">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Rain</p>
                                <p class="text-lg font-semibold">{{ $weather['current']['rain'] }} mm</p>
                            </div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4 flex items-center space-x-3 transform hover:scale-105 transition-transform duration-300 hover:shadow-lg">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Feels Like</p>
                                <p class="text-lg font-semibold">{{ $weather['current']['apparent_temperature'] }}°C</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Forecast -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">7-Day Forecast</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    @foreach ($weather['daily'] as $index => $day)
                        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 hover:shadow-xl">
                            <p class="text-sm font-semibold text-gray-600 mb-2">
                                {{ $index === 0 ? 'Today' : date('D, M j', strtotime($day['time'])) }}
                            </p>
                            <img src="{{ asset('assets/' . $day['weather_condition']['icons']['day']) }}" 
                                alt="weather-icon" 
                                class="w-16 h-16 mb-2"/>
                            <div class="text-center mb-2">
                                <p class="font-semibold text-gray-800">{{ $day['temperature_2m_max'] }}°C 🔼</p>
                                <p class="text-gray-600">{{ $day['temperature_2m_min'] }}°C 🔽</p>
                            </div>
                            <div class="mt-2 text-xs text-gray-500 space-y-1">
                                <p class="flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/>
                                    </svg>
                                    UV: {{ $day['uv_index_max'] }}
                                </p>
                                <p class="flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                    </svg>
                                    {{ $day['relative_humidity_2m_max'] }}%
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="text-center p-12 bg-white rounded-lg shadow-md">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
            </svg>
            <p class="text-xl text-gray-600">Enter a location to see weather information</p>
        </div>
    @endif

    @if(isset($weather) && !$weather['favorite'])
        <div class="mt-10">
            <form action="{{ route('save.favorite') }}" method="POST">
                @csrf
                <input type="hidden" name="name" value="{{ $weather['location_name'] }}">
                <input type="hidden" name="city" value="{{ $weather['location'] }}">
                <input type="hidden" name="latitude" value="{{ $weather['latitude'] }}">
                <input type="hidden" name="longitude" value="{{ $weather['longitude'] }}">
                <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Save to Favorites
                </button>
            </form>
        </div>
    @endif

    @if(session('success'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
</div>
