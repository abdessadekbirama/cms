@props([
'type'=>'button',
'color'=>'blue'
])

@php
$colors = [
'blue'=>'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
'red'=>'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded',
'green'=>'bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded',
'gray'=>'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded',
];
@endphp

<button
    type="{{$type}}"
    {{$attributes->merge(['class'=> 'px-4 py-2 rounded cursor-pointer '. ($colors[$color]??$colors['blue'])])}}>
    {{$slot}}
</button>