
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
  </head>
  <body>
    <div class="container">
    <br />
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Time</th>
        <th>Sale Number</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Currency</th>
        <th>Payment Link</th>
      </tr>
    </thead>
    <tbody>
      
      @foreach($sales as $sale)
      @php
        $date=date('Y-m-d', $sale['date']);
        @endphp
      <tr>
        <td>{{$sale['created_at']}}</td>
        <td>{{$sale['sale_number']}}</td>
        <td>{{$sale['description']}}</td>
        <td>{{$sale['amount']}}</td>
        <td>{{$sale['currency']}}</td>
        <td>{{$sale['payment_link']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  </body>
</html>