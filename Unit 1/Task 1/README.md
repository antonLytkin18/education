## Реализация типизированного стека и очереди.

Реализовать классы работы со стеком и очередью. Классы должны иметь общий интерфейс Collection.

Стек - структура данных с доступом к элементам по принципу LIFO (Last In First Out - Последний пришел - первый вышел). Данные добавляются в начало (конец, кому как удобно), оттуда же и извлекаются.

Очередь - структура данных с доступом к элементам по принципу FIFO (First In First Out - Первый пришел - Первый вышел). Данные добавляются в конец, а извлекаются из начала. 

В конструкторе установить тип элементов. Базовый класс должен быть единым, таким образом клиент не понимает с какой реализацией имеет дело.
Классы: `Collection, Stack, Queue`.

Методы коллекции (*Collection*):

* push(el)
* pop(): el
* size(): int

**Примечание:** Обновить файлы `composer` заранее.

**Проверка:** выполнение команды phpunit в каталоге задания