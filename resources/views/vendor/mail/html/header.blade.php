<tr>
<td class="header">
<a href="{{ $url }}">
@if (trim($slot) === 'Laravel')
<img src="https://hospitaldaher.com.br/wp-content/uploads/logo-hd-1.png" style="width: 250px !important" class="logo" alt="Daher Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
