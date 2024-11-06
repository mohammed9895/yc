<div class="w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
    @script
    <style>
        :host {
            --day-width: 60px;
            --day-height: 60px;
        }
    </style>
    @endscript
    <form class="space-y-10 min-h-[600px]" wire:submit="submit">
        <div>
            <h2 class="text-xl font-medium">Book {{ $hall->name }}</h2>
            <div class="mt-6 flex space-x-3 bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                @if($hall)
                    <div class="rounded-lg size-14 shrink-0" style="background: {{$hall->backgroundColor}}">
                    </div>
                @else
                    <div class="rounded-lg size-14 bg-gray-200 dark:bg-gray-600 shrink-0"></div>
                @endif

                <div class="w-full flex justify-between">
                    <div>
                        <div class="font-semibold">{{ $hall->name }}</div>
                        <div>{{ $hall->description ?? '' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore wire:ignore.self x-data="{
                init () {
                    availabilityJson = JSON.parse('{{$this->availabilityJson}}');
                    const picker = new easepick.create({
                        element: $refs.datepicker,
                        css: [
                            'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
                            'https://cdn.jsdelivr.net/npm/@easepick/lock-plugin@1.2.1/dist/index.css',
                            'https://yc.test/css/main.css',
                        ],
                        readonly: false,
                        zIndex: 1000,
                        plugins: [
                            'LockPlugin'
                        ],
                        LockPlugin: {
                            minDate: new Date(),
                            filter (date) {
                                return !availabilityJson.find(a => a.date === date.format('YYYY-MM-DD'))
                            }
                        },
                        setup (picker) {
                            picker.on('view', (e) => {
                                const { view, date, target } = e.detail
                                const dateString = date ? date.format('YYYY-MM-DD') : null
                                const availability = availabilityJson.find(a => a.date === dateString)
                                if (view === 'CalendarDay' && availability) {
                                    const span = target.querySelector('.day-slots') || document.createElement('span')
                                    span.className = 'day-slots'
                                    span.innerHTML = Object.keys(availability.slots).length + ' slots';
                                    target.append(span)
                                }
                            })
                        },
                    });
                    picker.on('select', (e) => {
                        document.getElementById('datepicker').dispatchEvent(
                            new CustomEvent('select', { detail: e.detail.date.format('YYYY-MM-DD') })
                        )
                    });
                },
            }">
            <h2 class="text-xl font-medium">1. When for?</h2>
            <input id="datepicker" x-ref="datepicker" suggest="false"
                   x-on:select="$wire.setDate($event.detail)"
                   autocomplete="off"
                   class="mt-6 text-sm bg-gray-100 dark:bg-gray-700 border-0 rounded-lg px-6 py-4 w-full"
                   placeholder="Choose a date">
        </div>

        <div>
            <h2 class="text-xl font-medium">2. Choose a slot</h2>
            <div class="mt-6">
                <div class="grid grid-cols-3 md:grid-cols-5 gap-8">
                    @if(!is_null($this->times) && $this->times->isNotEmpty())
                        @foreach($this->times as $time)
                            <button wire:click="setTime('{{ $time }}')" type="button" @class(['py-3 px-4 text-sm border border-gray-300 dark:border-gray-600 rounded-lg text-center hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer', 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600' => in_array($time,$form->slots)])>
                                {{ $time }}
                            </button>
                        @endforeach
                    @else
                        <p>No slots available for that date</p>
                    @endif
                </div>
            </div>
        </div>

        @if($form->time)
            <div>
                <h2 class="text-xl font-medium">2. Your details and book</h2>
                @error('form.time')
                <div class="bg-red-600 text-white py-4 px-6 rounded-lg mt-3">
                    {{ $message }}
                </div>
                @enderror

                <div class="mt-6">
                    <div>
                        <label for="name" class="sr-only">Title</label>
                        <input type="text" name="title" id="name" class="mt-1 text-sm bg-gray-100 dark:bg-gray-700 border-0 rounded-lg px-6 py-4 w-full" placeholder="Title" wire:model="form.title">
                        @error('form.title')
                        <div class="mt-2 text-sm font-medium text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="reason" class="sr-only">Reason</label>
                        <input type="text" name="reasone" id="reason" class="mt-1 text-sm bg-gray-100 dark:bg-gray-700 border-0 rounded-lg px-6 py-4 w-full" placeholder="Your Reason" wire:model="form.reasone">
                        @error('form.reasone')
                        <div class="mt-2 text-sm font-medium text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="pax" class="sr-only">PAX</label>
                        <input type="number" name="pax" id="pax" class="mt-1 text-sm bg-gray-100 dark:bg-gray-700 border-0 rounded-lg px-6 py-4 w-full" placeholder="PAX" wire:model="form.pax">
                        @error('form.pax')
                        <div class="mt-2 text-sm font-medium text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('form.date')
                     <div class="mt-2 text-sm font-medium text-red-500">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="mt-6 py-3 px-6 text-sm border border-gray-300 dark:border-gray-600 rounded-lg flex flex-row items-center justify-center text-center hover:text-gray-900 dark:text-white dark:hover:bg-gray-600 cursor-pointer bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-white font-medium">
                       <span class="mr-1">Make booking</span>
                        <svg wire:loading data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-6 h-6 text-gray-900 dark:text-white animate-spin">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </form>
</div>
