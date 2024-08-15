<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden p-4">
    <!-- Calendar Header -->

    <div class="flex items-center justify-between bg-primary-500 text-white py-4 px-6 rounded-md mb-4">
        <!-- Previous Button -->
        <button class="text-secondary-500 hover:text-secondary-700" wire:click="prev('{{ $cal->current->date }}')">
            &lt; Prev
        </button>

        <!-- Year and Month Display -->
        <div class="text-center">
            <div class="text-4xl font-bold">{{ $cal->current->year() }}</div>
            <div class="text-base">{{ $cal->current->month('F') }}</div>
        </div>

        <!-- Next Button -->
        <button class="text-secondary-500 hover:text-secondary-700" wire:click="next('{{ $cal->current->date }}')">
            Next &gt;
        </button>
    </div>

    <!-- Calendar Grid -->
    <div class="grid grid-cols-7 gap-2 text-center">
        <!-- Days of the Week -->
        @foreach(range(0, 6) as $i)
            <div class="font-bold text-2xl text-red-500">
                {{ $cal->current->language->getWeek($i)['l'] }}
            </div>
        @endforeach

        <!-- Empty Slots for Days Before 1st of the Month -->
        @for($i = 1; $i < $cal->days[1]->weekDay; $i++)
            <div class="aspect-square"></div>
        @endfor

        <!-- Dates with Square Boxes -->
        @foreach($cal->days as $day)
            <div class="border border-primary-500 p-2 flex flex-col justify-center items-center rounded-lg aspect-square text-3xl
            @if($day->isEqual($today)) bg-green-200 @endif
            @if($day->weekDay == 7) bg-red-200 @endif" wire:click="selectDate('{{ $day->date }}')">

                <!-- Day Number in the Center -->
                <div class="flex-1 flex items-center justify-center">
                    {{ $day->day() }}
                </div>

                <!-- Event at the Bottom -->
                @if(!empty($day->event))
                    <div class="text-sm truncate">{!! $day->event !!}</div>
                @else
                    <div class="mt-1">&nbsp;</div> <!-- Placeholder for empty space -->
                @endif
            </div>
        @endforeach


    </div>
    <!-- Event Modal -->
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                <h2 class="text-xl font-bold mb-4">Add Event on: {{ $cal->current->create($selectedDate)->format("Y/m/d") }}</h2>

                <!-- Event Form -->
                <form wire:submit.prevent="saveEvent">
                    <div class="mb-4">
                        <label for="event_name" class="block text-sm font-medium text-gray-700">Event Name</label>
                        <input type="text" id="event_name" wire:model="eventName"
                               class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <div class="flex justify-end">
                        <button type="button" wire:click="closeModal"
                                class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded-md">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>


