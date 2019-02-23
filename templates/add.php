<form class="form form--add-lot container" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <?php $classname = isset($errors['name']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
      <?php $name = $lot['name'] ?? ''; ?>
      <label for="lot-name">Наименование</label>
      <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота" value="<?= $name; ?>">
      <span class="form__error">Введите наименование лота</span>
    </div>
    <?php $classname = isset($errors['name']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>">
      <label for="category">Категория</label>
      <select id="category" name="category">
        <option>Выберите категорию</option>
        <?php foreach ($categories as $category): ?>
          <?php if(isset($category['name'])): ?>
              <option value="<?= strip_tags($category['id']); ?>"><?= strip_tags($category['name']); ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
      <span class="form__error">Выберите категорию</span>
    </div>
  </div>
  <?php $classname = isset($errors['description']) ? "form__item--invalid" : ""; ?>
  <div class="form__item form__item--wide <?= $classname; ?>">
    <?php $description = $lot['description'] ?? ''; ?>
    <label for="message">Описание</label>
    <textarea id="message" name="description" placeholder="Напишите описание лота"><?= $description; ?></textarea>
    <span class="form__error">Напишите описание лота</span>
  </div>
  <?php $classname = isset($errors['image']) ? "form__item--invalid" : ""; ?>
  <div class="form__item form__item--file <?= $classname; ?>"> <!-- form__item--uploaded -->
    <label>Изображение</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
      </div>
    </div>
    <div class="form__input-file">
      <?php $image = $lot['image'] ?? ''; ?>
      <input class="visually-hidden" type="file" id="photo2" name="image" value="<?= $image; ?>">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
  </div>
  <div class="form__container-three">
    <?php $classname = isset($errors['start_cost']) ? "form__item--invalid" : ""; ?>
    <div class="form__item form__item--small <?= $classname; ?>">
      <?php $start_cost = $lot['start_cost'] ?? ''; ?>
      <label for="lot-rate">Начальная цена</label>
      <input id="lot-rate" type="number" name="start_cost" placeholder="0" value="<?= $start_cost; ?>">
      <span class="form__error">Введите начальную цену</span>
    </div>
    <?php $classname = isset($errors['bet_step']) ? "form__item--invalid" : ""; ?>
    <div class="form__item form__item--small <?= $classname; ?>">
      <?php $bet_step = $lot['bet_step'] ?? ''; ?>
      <label for="lot-step">Шаг ставки</label>
      <input id="lot-step" type="number" name="bet_step" placeholder="0" value="<?= $bet_step; ?>">
      <span class="form__error">Введите шаг ставки</span>
    </div>
    <?php $classname = isset($errors['final_date']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>">
      <?php $final_date = $lot['final_date'] ?? ''; ?>
      <label for="lot-date">Дата окончания торгов</label>
      <input class="form__input-date" id="lot-date" type="date" name="final_date" value="<?= $final_date; ?>">
      <span class="form__error">Введите дату завершения торгов</span>
    </div>
  </div>
  <?php if (count($errors) !== 0): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php foreach($errors as $error => $value): ?>
      <span class="form__error form__error--bottom">Не заполнено поле: <?= $error[$value]; ?></span>
    <?php endforeach; ?>
  <?php endif; ?>
  <button type="submit" class="button">Добавить лот</button>
</form>
