@extends('layouts.main')
@section('title', 'Home')
@section('content')
<div class="row">
    <div class="col-sm-12">
       <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 onclick="$swal.fire()">Product Cart</h5>
            <div>
                <form action="{{route('importProject')}}" method="post" enctype="multipart/form-data">
                    @csrf
                <input type="file" name="file" id="">
                <button class="action" type="submit">Upload</button>
            </div>
        </form>
        </div>
        <div class="card-body" data-intro="This is the name of this site">
            <div class="user-status">
                <table class="table table-bordernone">
                    <thead>
                        <tr>
                            <th scope="col">Details</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Status</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Simply dummy text of the printing</td>
                            <td>1</td>
                            <td class="font-secondary">Pending</td>
                            <td>$6523</td>
                        </tr>
                        <tr>
                            <td>Long established</td>
                            <td>5</td>
                            <td class="font-danger">Cancle</td>
                            <td>$6523</td>
                        </tr>
                        <tr>
                            <td>sometimes by accident</td>
                            <td>10</td>
                            <td class="font-danger">Cancle</td>
                            <td>$6523</td>
                        </tr>
                        <tr>
                            <td>Classical Latin literature</td>
                            <td>9</td>
                            <td class="font-info">Return</td>
                            <td>$6523</td>
                        </tr>
                        <tr>
                            <td>keep the site on the Internet</td>
                            <td>8</td>
                            <td class="font-secondary">Pending</td>
                            <td>$6523</td>
                        </tr>
                        <tr>
                            <td>Molestiae consequatur</td>
                            <td>3</td>
                            <td class="font-danger">Cancle</td>
                            <td>$6523</td>
                        </tr>
                        <tr>
                            <td>Pain can procure</td>
                            <td>8</td>
                            <td class="font-info">Return</td>
                            <td>$6523</td>
                        </tr>
    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
@section('script')
{{-- <script>
    $('#aha').on('click',function () {
            myLoader('#aha','show');
            setTimeout(() => {
                myLoader('#aha','hide');
            }, 2000);
        })
</script> --}}
@endsection