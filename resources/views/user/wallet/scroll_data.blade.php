@foreach($transcation as $key => $r)
<tr>
    <td>{{ ($key+1) + ($transcation->currentPage() - 1)*$transcation->perPage() }}</td>
    <td>{{date('d-m-Y',strtotime($r->created_at))}}</td>
    <td>{{ ($r->transcation_type == 1) ? 'Promotional' : 'Transactional' }}</td>
    <td>@if($r->debit_amount != 0) Dr ₹{{ $r->debit_amount }} @elseif($r->credit_amount != 0) Cr ₹{{ $r->credit_amount }}
        @else ₹0 @endif</td>
</tr>
@endforeach