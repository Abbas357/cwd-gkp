@php
$card = $row->cardable_type::findOrFail($row->cardable_id);
$url = '';
$hash = '';

switch (class_basename($row->cardable_type)) {
    case 'ServiceCard':
        $url = route('admin.apps.service_cards.index', []);
        $queryParams = ['id' => $row->cardable_id, 'type' => 'card'];
        $hash = 'verified';
        break;
    case 'ContractorRegistration':
        $url = route('admin.apps.contractors.registration.index', []);
        $queryParams = ['id' => $row->cardable_id, 'type' => 'card'];
        $hash = 'approved';
        break;
    case 'Standardization':
        $url = route('admin.apps.standardizations.index', []);
        $queryParams = ['id' => $row->cardable_id, 'type' => 'card'];
        $hash = 'approved';
        break;
}

$finalUrl = $url;
if (!empty($queryParams)) {
    $finalUrl .= '?' . http_build_query($queryParams);
}
if (!empty($hash)) {
    $finalUrl .= '#' . $hash;
}
@endphp
<a class="fs-6 badge bg-info" href="{{ $finalUrl }}" target="_blank"><i class="card-btn bi-credit-card" title="Generate Card" data-bs-toggle="tooltip"></i> View Card</a>