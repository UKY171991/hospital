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
            this.checkRow('{{ $module['key'] }}', true);
        @endforeach
    },
    uncheckAll() {
        @foreach($modules as $module)
            this.checkRow('{{ $module['key'] }}', false);
        @endforeach
    },
    checkRow(module, value) {
        ['c', 'r', 'u', 'd'].forEach(action => {
            $wire.set('data.permissions.' + module + '.' + action, value);
        });
    }
}" class="w-full">
<div x-data="{
    checkAll() {
        @foreach($modules as $module)
            this.checkRow('{{ $module['key'] }}', true);
        @endforeach
    },
    uncheckAll() {
        @foreach($modules as $module)
            this.checkRow('{{ $module['key'] }}', false);
        @endforeach
    },
    checkRow(module, value) {
        ['c', 'r', 'u', 'd'].forEach(action => {
            $wire.set('data.permissions.' + module + '.' + action, value);
        });
    }
}" class="w-full">
    <!-- Header Controls -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 p-6 bg-gradient-to-br from-indigo-50/50 to-white rounded-2xl border border-indigo-100 shadow-sm relative overflow-hidden">
        <div class="relative z-10 flex items-start gap-4">
            <div class="p-3 bg-indigo-600 rounded-xl shadow-lg">
                <x-heroicon-o-shield-check class="text-white" style="width: 28px; height: 28px;" />
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-900 tracking-tight">Security Matrix</h3>
                <p class="text-sm text-slate-500 font-medium mt-1">Configure workspace-wide access policies with precision.</p>
            </div>
        </div>
        
        <div class="relative z-10 flex items-center gap-3">
            <button type="button" @click="checkAll" class="flex items-center gap-2 px-5 py-2.5 text-xs font-bold uppercase tracking-widest text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all active:scale-95">
                <x-heroicon-o-check-circle class="hidden sm:block" style="width: 16px; height: 16px;" />
                Grant Everything
            </button>
            <button type="button" @click="uncheckAll" class="flex items-center gap-2 px-5 py-2.5 text-xs font-bold uppercase tracking-widest text-slate-600 bg-slate-50 rounded-xl hover:bg-slate-100 border border-slate-200 transition-all active:scale-95">
                <x-heroicon-o-x-circle class="hidden sm:block" style="width: 16px; height: 16px;" />
                Revoke All
            </button>
        </div>
    </div>

    <!-- Matrix Table -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-x-auto">
        <table class="w-full text-left table-fixed min-w-[600px]">
            <thead>
                <tr class="bg-slate-50/80">
                    <th class="w-2/5 py-6 px-8 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Clinical Module</th>
                    @foreach(['c' => 'Create', 'r' => 'Read', 'u' => 'Update', 'd' => 'Delete'] as $char => $label)
                        <th class="py-6 px-2 text-center">
                            <div class="inline-flex flex-col items-center gap-1">
                                <span class="text-base font-black text-slate-900">{{ strtoupper($char) }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $label }}</span>
                            </div>
                        </th>
                    @endforeach
                    <th class="w-20 py-6 px-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Row</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach ($modules as $module)
                    <tr class="hover:bg-indigo-50/20 transition-colors group">
                        <td class="py-5 px-8">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-slate-50 rounded-2xl group-hover:bg-white group-hover:shadow-md transition-all duration-300 ring-1 ring-slate-100 group-hover:ring-indigo-100">
                                    @svg($module['icon'], 'text-slate-400 group-hover:text-indigo-600 transition-colors', ['style' => 'width: 24px; height: 24px;'])
                                </div>
                                <div class="truncate">
                                    <span class="block text-sm font-bold text-slate-800 group-hover:text-indigo-950 transition-colors tracking-tight">{{ $module['label'] }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5 opacity-70">Workspace</span>
                                </div>
                            </div>
                        </td>
                        
                        @foreach (['c', 'r', 'u', 'd'] as $action)
                            <td class="py-5 px-2">
                                <div class="flex justify-center">
                                    <label class="relative flex items-center cursor-pointer group/check">
                                        <input 
                                            type="checkbox" 
                                            wire:model.defer="data.permissions.{{ $module['key'] }}.{{ $action }}" 
                                            class="peer sr-only"
                                        >
                                        <div class="w-7 h-7 bg-slate-100 rounded-lg border-2 border-transparent peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all duration-200 peer-hover:border-slate-300 peer-checked:peer-hover:border-indigo-700 flex items-center justify-center shadow-sm">
                                            <svg class="text-white opacity-0 peer-checked:opacity-100 transition-opacity" style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            </td>
                        @endforeach

                        <td class="py-5 px-4">
                            <div class="flex justify-center">
                                <button type="button" @click="checkRow('{{ $module['key'] }}', true)" title="Check All for {{ $module['label'] }}" class="p-2 text-slate-200 hover:text-indigo-500 hover:bg-indigo-50 rounded-lg transition-all active:scale-95">
                                    <x-heroicon-o-plus-circle style="width: 20px; height: 20px;" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
