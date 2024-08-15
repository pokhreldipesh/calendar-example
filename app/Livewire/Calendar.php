<?php

namespace App\Livewire;

use Dipesh\Calendar\Calendar as MyCalendar;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Calendar extends Component
{
    /**  Selected date for the calendar */
    public $date;

    /**  Current date */
    public $today;

    /**  Modal visibility state */
    public $showModal = false;

    /**  Selected date for event creation */
    public $selectedDate;

    /**  Event storage with date as key */
    public $events = [];

    /**  Name of the event to be added */
    public $eventName;

    /**
     * Initializes the calendar component.
     *
     * @throws Exception
     */
    public function mount(): void
    {
        $this->date = $this->cal->current->date;
        $this->today = $this->date;
    }

    /**
     * Retrieves a MyCalendar instance for a current calendar date.
     *
     * @param string|null $date
     * @return MyCalendar
     * @throws Exception
     */
    #[Computed]
    public function cal(): MyCalendar
    {
        return (new MyCalendar($this->date));
    }

    /**
     * Navigates to the next month in the calendar.
     *
     * @param string $date
     * @return void
     * @throws Exception
     */
    public function next(string $date): void
    {
        $this->date = $this->cal->nextMonth()->current->date;
    }

    /**
     * Navigates to the previous month in the calendar.
     *
     * @param string $date
     * @return void
     * @throws Exception
     */
    public function prev(string $date): void
    {
        $this->date = $this->cal->prevMonth()->current->date;
    }

    /**
     * Selects a date and opens the event modal.
     *
     * @param string $date
     * @return void
     */
    public function selectDate(string $date): void
    {
        $this->showModal = true;
        $this->selectedDate = $date;
    }

    /**
     * Closes the event modal and resets the event name.
     *
     * @return void
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset('eventName');
    }

    /**
     * Validates and saves the event for the selected date.
     *
     * @return void
     */
    public function saveEvent(): void
    {
        $validated = $this->validate([
            'eventName' => 'required|string|max:255',
        ]);

        $this->events[$this->selectedDate] = $validated['eventName'];

        $this->closeModal();
    }

    /**
     * Renders the calendar view with events.
     *
     * @return View|Factory|Application
     * @throws Exception
     */
    public function render(): View|Factory|Application
    {
        return view('livewire.calendar', [
            'cal' => $this->cal->setEvents(function($cal, $days) {
                foreach ($days as $day) {
                    if (isset($this->events[$day->date])) {
                        $day->setEvent($this->events[$day->date]);
                    }
                }
            })
        ]);
    }
}
