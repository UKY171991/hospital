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
}" class="max-w-full">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 pb-6 border-b border-gray-100 gap-4">
        <div>
            <h3 class="text-xl font-bold text-gray-900 tracking-tight flex items-center gap-2.5">
                <div class="p-2 bg-indigo-50 rounded-xl">
                    <x-heroicon-o-shield-check class="text-indigo-600 block" style="width: 24px; height: 24px;" />
                </div>
                Access Control Matrix
            </h3>
            <p class="text-sm text-gray-500 mt-1 font-medium">Fine-tune system capabilities for this role by selecting permissions below.</p>
        </div>
        <div class="flex items-center gap-4 bg-gray-50/50 p-2 rounded-2xl border border-gray-100">
            <button 
                type="button" 
                @click="checkAll"
                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-indigo-700 bg-white border border-indigo-100 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 transition-all duration-300 shadow-sm hover:shadow active:scale-95 group"
            >
                <x-heroicon-o-check-circle class="group-hover:translate-y-[-1px] transition-transform" style="width: 18px; height: 18px;" />
                Grant All Access
            </button>
            <button 
                type="button" 
                @click="uncheckAll"
                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow active:scale-95 group"
            >
                <x-heroicon-o-x-circle class="group-hover:translate-y-[1px] transition-transform" style="width: 18px; height: 18px;" />
                Revoke All
            </button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] bg-white p-2">
        <table class="w-full text-left border-separate border-spacing-0">
            <thead>
                <tr>
                    <th class="py-6 px-8 text-xs font-black text-gray-400 uppercase tracking-widest bg-gray-50/50 first:rounded-tl-2xl">Medical Workspace</th>
                    @php
                        $cols = [
                            'c' => ['label' => 'Create', 'char' => 'C', 'color' => 'success', 'desc' => 'Allow record creation'],
                            'r' => ['label' => 'Read', 'char' => 'R', 'color' => 'info', 'desc' => 'Allow viewing records'],
                            'u' => ['label' => 'Update', 'char' => 'U', 'color' => 'warning', 'desc' => 'Allow editing records'],
                            'd' => ['label' => 'Delete', 'char' => 'D', 'color' => 'danger', 'desc' => 'Allow permanent deletion'],
                        ];
                    @endphp
                    @foreach($cols as $key => $col)
                        <th class="py-6 px-4 bg-gray-50/50 last:rounded-tr-2xl">
                            <div class="flex flex-col items-center gap-1.5" title="{{ $col['desc'] }}">
                                <span class="bg-indigo-100 text-indigo-700 w-8 h-8 flex items-center justify-center rounded-lg text-sm font-black shadow-sm">{{ $col['char'] }}</span>
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter">{{ $col['label'] }}</span>
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($modules as $module)
                    <tr class="hover:bg-indigo-50/40 transition-all duration-300 group">
                        <td class="py-6 px-8 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-gray-50 rounded-2xl group-hover:bg-white group-hover:shadow-md transition-all duration-500 ring-1 ring-gray-100/50">
                                    @svg($module['icon'], 'text-gray-400 group-hover:text-indigo-600 transition-colors', ['style' => 'width: 24px; height: 24px;'])
                                </div>
                                <div>
                                    <span class="block font-extrabold text-gray-800 tracking-tight group-hover:text-indigo-950 transition-colors text-base">{{ $module['label'] }}</span>
                                    <span class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-0.5 block opacity-60">Module Scope</span>
                                </div>
                            </div>
                        </td>
                        @foreach (['c', 'r', 'u', 'd'] as $action)
                            <td class="py-6 px-4">
                                <div class="flex justify-center items-center h-full">
                                    <div class="relative flex items-center justify-center w-8 h-8">
                                        <input 
                                            type="checkbox" 
                                            wire:model.defer="data.permissions.{{ $module['key'] }}.{{ $action }}" 
                                            class="peer w-6 h-6 text-indigo-600 rounded-lg border-2 border-gray-200 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 cursor-pointer hover:border-indigo-400 checked:border-indigo-600 shadow-sm"
                                        >
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
