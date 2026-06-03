@php
$urlArray = url()->full();
$segments = explode('/', $urlArray);
$numSegments = count($segments);
$currentSegmentt = $segments[$numSegments - 1];
@endphp

<div class="card-body py-sm-4">
    <ul class="nav nav-tab" role="tablist">
        <li class="nav-item">
            <a  class="nav-link {{ $currentSegmentt === 'show' ? 'active' : ''}}"  
            href="{{ route('seller.member.show', $member->id) }}">
                <div class="tooltip">Details</div>
                <i class="fa-solid fa-circle-info"></i>
            </a>
        </li>

        <li class="nav-item notes">
            <a class="nav-link {{ $currentSegmentt === 'note' ? 'active' : ''}}" 
            href="{{ route('seller.member.show.note', $member->id) }}">
                <div class="tooltip">Notes</div>
                <i class="fas fa-notes-medical"></i>
            </a>
        </li>

        <li class="nav-item hauoraPlan">
            <a class="nav-link {{ $currentSegmentt === 'hauora_plan' ? 'active' : ''}}" 
            href="{{ route('seller.member.show.hauora.plan', $member->id) }}">
                <div class="tooltip">Hauora Plan</div>
                <i class="fa-solid fa-solid fa-warehouse"></i>
            </a>
        </li>

        <li class="nav-item medication">
            <a class="nav-link {{ $currentSegmentt === 'medication' ? 'active' : ''}}" 
            href="{{ route('seller.member.show.medication', $member->id) }}">
                <div class="tooltip">Medication</div>
                <i class="fa-solid fa-capsules"></i>
            </a>
        </li>

        <li class="nav-item immunization">
            <a class="nav-link {{ $currentSegmentt === 'immunization' ? 'active' : ''}}" 
            href="{{ route('seller.member.show.immunization', $member->id) }}">
                <div class="tooltip">Immunisation</div>
                <i class="fa-solid fa-syringe"></i>
            </a>
        </li>

        <li class="nav-item family-tree">
            <a class="nav-link {{ $currentSegmentt === 'family_tree' ? 'active' : ''}}" 
            href="{{ route('seller.member.show.family.tree', $member->id) }}">
                <div class="tooltip">Famity Tree</div>
                <i class="fa-solid fa-people-group"></i>
            </a>
        </li>

    </ul>
</div>