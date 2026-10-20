# Лабораторна 2 — Доступ.City

## Файли
- `docs/architecture.md` — опис предметної галузі й повний Use Case.
- `docs/use-case-diagram.puml` — вихідний код діаграми варіантів використання.
- `docs/class-diagram.puml` — вихідний код діаграми класів.
- `docs/*.png` — зображення для звіту.
- `Звіт_Лаб2_ДоступCity.docx` — редагований проєкт звіту.

## Перед здачею
1. Перевірити назву закладу/тему з викладачем.
2. Переглянути обидві діаграми й перевірити, чи читабельні вони у звіті.
3. Додати дані університету, ПІБ, викладача й за потреби скриншоти PlantUML.
4. Додати `docs/` у наявний репозиторій `web-programming`, не замінюючи файли лабораторної 1.
5. Створити гілку `feature/system-design`, закомітити та відправити зміни.
6. Створити Pull Request і перевірити CI.

## Команди Git
```bash
git checkout main
git pull
git checkout -b feature/system-design
git add docs/
git commit -m "Add initial system design, use cases, and UML diagrams"
git push -u origin feature/system-design
```
Після цього відкрий GitHub, створи Pull Request з `feature/system-design` у `main`, перевір CI і злий PR після успішної перевірки.
