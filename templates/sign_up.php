<form class="form container" action="sign_up.php" method="post" enctype="multipart/form-data">
  <h2>Регистрация нового аккаунта</h2>
  <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
  <div class="form__item <?= $classname; ?>">
    <label for="email">E-mail*</label>
    <?php $email = $fields['email'] ?? ''; ?>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $email; ?>">
    <span class="form__error"><?= strip_tags($errors['email']) ?? ''; ?></span>
  </div>
  <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
  <div class="form__item <?= $classname; ?>">
    <label for="password">Пароль*</label>
    <?php $password = $fields['password'] ?? ''; ?>
    <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= $password; ?>">
    <span class="form__error"><?= strip_tags($errors['password']) ?? ''; ?></span>
  </div>
  <?php $classname = isset($errors['name']) ? "form__item--invalid" : ""; ?>
  <div class="form__item <?= $classname; ?>">
    <label for="name">Имя*</label>
    <?php $name = $fields['name'] ?? ''; ?>
    <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $name; ?>">
    <span class="form__error"><?= strip_tags($errors['name']) ?? ''; ?></span>
  </div>
  <?php $classname = isset($errors['message']) ? "form__item--invalid" : ""; ?>
  <div class="form__item <?= $classname; ?>">
    <label for="message">Контактные данные*</label>
    <?php $message = $fields['message'] ?? ''; ?>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= $message; ?></textarea>
    <span class="form__error"><?= strip_tags($errors['message']) ?? ''; ?></span>
  </div>
  <?php $classname = isset($errors['image']) ? "form__item--invalid" : ""; ?>
  <div class="form__item form__item--file form__item--last <?= $classname; ?>">
    <label>Аватар</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="photo2" value="" name="image">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
      <span class="form__error"><?= strip_tags($errors['image']) ?? ''; ?></span>
    </div>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
