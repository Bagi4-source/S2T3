<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<form class="decor" method="POST">
    <div class="form-left-decoration"></div>
    <div class="form-right-decoration"></div>
    <div class="circle"></div>
    <div class="form-inner">
        <h3>Отправить заявку</h3>
        <input type="text" placeholder="Имя" name="fio" required>
        <input type="email" placeholder="Email" name="email" required>
        <input type="date" name="year" id="bday" required>

        <div class="form_radio">
            <span>Пол: </span>

            <input id="radio-1" type="radio" name="gender" value="м" checked>
            <label for="radio-1">Мужской</label>

            <input id="radio-2" type="radio" name="gender" value="ж">
            <label for="radio-2">Женский</label>
        </div>

        <div class="form_radio">
            <span>Число конечностей: </span>
            <?php
            for ($i = 0; $i <= 4; $i++) {
                printf('<input id="limbs-%d" type="radio" name="limbs" value="%d" checked>
                               <label for="limbs-%d">%d</label>', $i, $i, $i, $i);
            }
            ?>
        </div>

        <div class="field superpower">
            <label for="superpower">Сверхспособности:</label>
            <select name="abilities[]" id="superpower" multiple="multiple" required>
                <?php
                $user = 'u52803';
                $pass = '9294062';
                $db = new PDO('mysql:host=localhost;dbname=u52803', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
                $abilities = $db->query("SELECT id, name FROM abilities;");
                while ($row = $abilities->fetch(PDO::FETCH_ASSOC)) {
                    printf('<option value="%d">%s</option>', $row['id'], $row['name']);
                }
                $db = null;
                ?>

            </select>
        </div>
        <textarea placeholder="Биография..." name="biography" rows="3"></textarea>
        <div class="checkbox">
            <input type="checkbox" class="custom-checkbox" id="check" name="checkbox" required>
            <label for="check">согласен с политикой конфиденциальности</label>
        </div>
        <input type="submit" value="Отправить">

    </div>
</form>