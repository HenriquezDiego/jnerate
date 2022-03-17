<?php
include 'src/utils/formatter.php';

date_default_timezone_set("America/El_Salvador");
$name = $_POST['file-name'];
$name = validName($name);
$file = fopen($name, "a+");
$content = "";
$date = getFileDate($name);
if (filesize($name) > 0) {
    $content = fread($file, filesize($name));
}
fclose($file);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assest/css/style.css">
    <link rel="stylesheet" href="assest/css/components.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Document</title>
</head>

<body>
    <!-- Canvas -->
    <canvas class="orb-canvas"></canvas>
    <h3><span class="text-gradient">Jnerate</span></h3>
    <div class="overlay-text">
        <div style="display: flex;">
        <label for="name" style="text-align: left;font-size: 0.7em;">Archivo: <span><?php echo $name ?></span></label>
        <label for="date" style="text-align: right;font-size: 0.7em; margin-left: 65%;">Ultima modificacion: <span id="date"><?php echo $date ?></span></label>
        </div>
        <label id="path" for="path" style="visibility: hidden;"><?php echo $name ?></label>
        <textarea style="resize: none;" name="text" id="text" cols="130" rows="15"><?php echo $content; ?></textarea>
        <div class="row text-center" style="margin-top: 10px;">
            <div class="col-md-3">
                <button data-toggle="tooltip" data-placement="bottom" title="Home" class="btn-op"><a style="color: white;" href="index.html"> <i data-feather="home">Home</i></a></button>
            </div>
            <div class="col-md-3">
                <button data-toggle="tooltip" data-placement="bottom" title="Guardar" class="btn-op" onclick="send()"><i data-feather="save">Guardar</i></button>
            </div>
            <div class="col-md-3">
                <button data-toggle="tooltip" data-placement="bottom" title="Eliminar" class="btn-op" onclick="send(true)"><i data-feather="trash-2">Eliminar</i></button>
            </div>
            <div class="col-md-3">
                <button data-toggle="tooltip" data-placement="bottom" title="Descargar" class="btn-op"><a style="color: white;" href="<?php echo $name; ?>" download><i data-feather="download">Descargar</i></a></button>
            </div>
        </div>


        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast border-0 f" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    ¡Tus datos han sido guardados!
                </div>
            </div>
        </div>

    </div>
</body>
<script type="module" src="assest/js/pixi-custom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    feather.replace()
    function send(remove = false) {
        let data = {
            path: document.getElementById("path").innerHTML,
            content: document.getElementById("text").value,
            flag: remove
        }
        fetch("main.php", {
                method: 'POST',
                body: JSON.stringify(data)
            }).then(res => {
                if (res.status == 204) {
                    window.location.href = "index.html";
                }
                if (res.status == 200) {
                    let toastLiveExample = document.getElementById('liveToast')
                    let toast = new bootstrap.Toast(toastLiveExample);
                    toast.show()
                    console.log()
                }
                return res.json();
            })
            .then(data =>{
                document.getElementById("date").innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
</script>

</html>