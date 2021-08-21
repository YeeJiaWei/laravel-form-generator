<x-card-admin>
    <form method="post" action="{{ route($route_name, $update_route_obj) }}">
        @csrf @if($update_route_obj) @method('put') @endif

        @foreach($fields as $field)
            @if(array_key_exists('row', $field))
                <div class="flex items-center mb-3">
                    @foreach($field['row'] as $row_field)
                        <div
                                class="@if($row_field['is_row']) flex justify-center items-center @endif
                                        w-1/{{ count($field['row']) }} mr-3">

                            <label for="{{ $row_field['name'] }}"
                                   class="@if($row_field['is_row']) w-1/3 @endif text-right mr-6">
                                {{ $row_field['label'] }}
                            </label>

                            @if($row_field['type']== 'input')
                                <input id="{{ $row_field['name'] }}" type="{{ $row_field['input_type'] }}"
                                       name="{{ $row_field['name'] }}"
                                       value="{{ $row_field['value'] }}"
                                       class="@if($row_field['is_row']) w-2/3 @else block mt-1 w-full @endif
                                               rounded-md shadow-sm border-gray-300 focus:border-gray-300
                                               focus:ring focus:ring-gray-200 focus:ring-opacity-50"/>

                                {{--                                @elseif($row_field['type']=='textarea')--}}
                                {{--                                    <textarea id="{{ $row_field['name'] }}" name="{{ $row_field['name'] }}"--}}
                                {{--                                              rows="{{ $row_field['rows'] }}"--}}
                                {{--                                              class="@if($row_field['is_row']) w-2/3 @else block mt-1 w-full @endif--}}
                                {{--                                                  rounded-md shadow-sm border-gray-300 focus:border-gray-300--}}
                                {{--                                                  focus:ring focus:ring-gray-200 focus:ring-opacity-50"--}}
                                {{--                                    >{{ $row_field['value'] }}</textarea>--}}

                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="@if($field['is_row']) flex justify-center items-center @endif mb-3">

                    <label for="{{ $field['name'] }}"
                           class="@if($field['is_row']) w-1/3 @endif text-right mr-6">
                        {{ $field['label'] }}
                    </label>

                    @if($field['type']== 'input')
                        <input id="{{ $field['name'] }}" type="{{ $field['input_type'] }}"
                               name="{{ $field['name'] }}"
                               value="{{ $field['value'] }}"
                               class="@if($field['is_row']) w-2/3 @else block mt-1 w-full @endif
                                       rounded-md shadow-sm border-gray-300 focus:border-gray-300
                                       focus:ring focus:ring-gray-200 focus:ring-opacity-50"/>

                    @elseif($field['type']=='textarea')
                        <textarea id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                  rows="{{ $field['rows'] }}"
                                  class="@if($field['is_row']) w-2/3 @else block mt-1 w-full @endif
                                          rounded-md shadow-sm border-gray-300 focus:border-gray-300
                                          focus:ring focus:ring-gray-200 focus:ring-opacity-50"
                        >{{ $field['value'] }}</textarea>

                    @endif
                </div>
            @endif
        @endforeach
        <x-validation-errors/>
        <div class="text-right">
            @if($update_route_obj)
                <button
                        class="px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest">
                    Update
                </button>
            @else
                <button
                        class="px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest">
                    Create
                </button>
            @endif
        </div>
    </form>
</x-card-admin>