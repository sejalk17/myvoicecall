@foreach($transcation as $key => $r)
<tr>
    <td>{{ ($key+1) + ($transcation->currentPage() - 1)*$transcation->perPage() }}</td>
    <td>{{date('d-m-Y',strtotime($r->created_at))}}</td>
    <td>{{$r->created_by}}</td>
    <td>{{ ($r->transcation_type == 1) ? 'Promotional' : 'Transactional' }}</td>
    <td>₹{{ $r->debit_amount }}</td>
    <td>₹{{ $r->credit_amount }} </td>
</tr>
@endforeach