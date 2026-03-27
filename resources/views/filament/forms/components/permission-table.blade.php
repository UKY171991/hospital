@php
    $modules = [
        ['label' => 'Doctors', 'key' => 'doctors', 'icon' => 'heroicon-o-user-plus'],
        ['label' => 'Patients', 'key' => 'patients', 'icon' => 'heroicon-o-users'],
        ['label' => 'Appointments', 'key' => 'appointments', 'icon' => 'heroicon-o-calendar-days'],
        ['label' => 'Departments', 'key' => 'departments', 'icon' => 'heroicon-o-building-office-2'],
        ['label' => 'Pathology Records', 'key' => 'pathology_records', 'icon' => 'heroicon-o-beaker'],
        ['label' => 'Pathology Tests', 'key' => 'pathology_tests', 'icon' => 'heroicon-o-clipboard-document-list'],
        ['label' => 'Medicines', 'key' => 'medicines', 'icon' => 'heroicon-o-archive-box'],
        ['label' => 'Medicine Sales', 'key' => 'medicine_sales', 'icon' => 'heroicon-o-shopping-cart'],
    ];
@endphp

<div x-data="{
    checkAll() {
        @foreach($modules as $module)
            @foreach(['c', 'r', 'u', 'd'] as $action)
                $wire.set('data.permissions.{{ $module['key'] }}.{{ $action }}', true);
            @endforeach
        @endforeach
    },
    uncheckAll() {
        @foreach($modules as $module)
            @foreach(['c', 'r', 'u', 'd'] as $action)
                $wire.set('data.permissions.{{ $module['key'] }}.{{ $action }}', false);
            @endforeach
        @endforeach
    }
}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 w-full">
    <div class="flex items-center justify-between mb-6 border-b border-gray-50 pb-4">
        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
            <x-heroicon-o-shield-check class="text-indigo-600" style="width: 24px; height: 24px;" />
            Module Access Control
        </h3>
        <div class="flex items-center gap-3">
            <button 
                type="button" 
                @click="checkAll"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border-2 border-indigo-100 rounded-lg hover:bg-indigo-100 hover:border-indigo-200 transition-all duration-200 shadow-sm active:scale-95"
            >
                <x-heroicon-o-check-circle style="width: 16px; height: 16px;" />
                Select All
            </button>
            <button 
                type="button" 
                @click="uncheckAll"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-gray-700 bg-gray-50 border-2 border-gray-100 rounded-lg hover:bg-gray-100 hover:border-gray-200 transition-all duration-200 shadow-sm active:scale-95"
            >
                <x-heroicon-o-x-circle style="width: 16px; height: 16px;" />
                Clear All
            </button>
        </div>
    </div>

    <div class="overflow-hidden border border-gray-100 rounded-xl">
        <table class="w-full text-left">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="py-4 px-6 text-sm font-extrabold text-gray-600 uppercase tracking-widest border-b border-gray-100">Functional Area</th>
                    @foreach(['C' => 'Create', 'R' => 'Read', 'U' => 'Update', 'D' => 'Delete'] as $char => $full)
                        <th class="py-4 px-4 text-center text-sm font-extrabold text-gray-600 border-b border-gray-100" title="{{ $full }}">
                            <div class="flex flex-col items-center">
                                <span class="text-indigo-600">{{ $char }}</span>
                                <span class="text-[10px] text-gray-400 font-normal mt-0.5 tracking-tighter">{{ substr($full, 0, 1) }}</span>
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 bg-white">
                @foreach ($modules as $module)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-indigo-100/50 transition-colors">
                                    @svg($module['icon'], 'text-gray-500 group-hover:text-indigo-600 transition-colors', ['style' => 'width: 20px; height: 20px;'])
                                </div>
                                <span class="font-bold text-gray-700 tracking-tight group-hover:text-indigo-950 transition-colors">{{ $module['label'] }}</span>
                            </div>
                        </td>
                        @foreach (['c', 'r', 'u', 'd'] as $action)
                            <td class="py-4 px-4">
                                <div class="flex justify-center">
                                    <input 
                                        type="checkbox" 
                                        wire:model.defer="data.permissions.{{ $module['key'] }}.{{ $action }}" 
                                        class="w-5 h-5 text-indigo-600 rounded-md border-gray-300 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 cursor-pointer hover:border-indigo-400 shadow-sm"
                                    >
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
