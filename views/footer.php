</div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.1/mdb.min.js"></script>
<script type="text/javascript" src="<?= URL; ?>public/MDB/js/mdb.min.js"></script>
<script src="<?= URL; ?>public/js/axios.min.js"></script>
<script src="<?= URL; ?>public/js/libs.js"></script>
<?php
if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
    }
}
if (isset($this->tsx)) {
    foreach ($this->tsx as $tsx) {
        echo '<script type="text/typescript" src="' . URL . 'views/' . $tsx . '"></script>';
    }
}
?>
</html>