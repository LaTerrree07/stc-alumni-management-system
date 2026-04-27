@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(["class" => "border-gray-300 focus:border-[#6B0F1A] focus:ring-[#6B0F1A] rounded-md shadow-sm"]) }}>
