<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>
    .container-file-iten{

      @if($demands->filename!=null && $extensao!="zip")

        background-image:url({!!$demands->filename!!});
        background-repeat: no-repeat;
        background-size: cover;
        background-position-y: center;
        background-position-x: center;

      @elseif($extensao=="zip")

        background-image:url('storage/comprimido.png');
        background-position-y: center;
        background-position-x: center;
        background-repeat: no-repeat;
        background-size: 35%;

      @else

        background-image:url('storage/no-file.png');
        background-position-y: center;
        background-position-x: center;
        background-repeat: no-repeat;
        
      @endif

      
    }
  </style>


    @foreach($anexos as $anexo)
    <div style="margin:10px; background-color:red">{{$anexo->id}}
    @endforeach

</body>
</html>