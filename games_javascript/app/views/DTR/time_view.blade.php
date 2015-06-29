	





<center>
{{ link_to_route('change.pass', 'Change Password') }}
<table border = "1">
  <thead>
    <tr>
      <th>USER_NAME</th>
      <th>PASSWORD</th>
      <th>UPDATED_AT</th>
      <th>CREATED_AT</th>
        <th>Remember_Token</th>
          <th>Role</th>
    </tr>
  </thead>
  <tbody>
    <tr>

@foreach($user as $data)
    <td>{{ $data->username }}</td>
    <td>{{ $data->password }}</td>
    <td>{{ $data->created_at }}</td>
     <td>{{ $data->updated_at }}</td>
      <td>{{ $data->remember_token }}</td>
    <td>{{ $data->role }}</td>
 
    {{ Form::close() }}
  
   </tr>
@endforeach
	</tbody>
</table>

<br/>
<br/>

</center>

