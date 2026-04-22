@if ($file)
    <audio controls style="width: 100%;">
        <source src="{{ Storage::url($file) }}" type="audio/mpeg">
    </audio>
@endif
