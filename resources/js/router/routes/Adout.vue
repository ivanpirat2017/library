<template >
    <div class="Adout m5-l-r">

        <h2>Приветствуем Вас на сайте электронной библиотеки «Library»</h2>
        <div class="AdoutTexts">
            <div class=" ">
                <h2>1</h2>
                <p class="AdoutC1">
                    На сайте представлены книги разных жанров для бесплатного скачивания. Для удобства пользования
                    библиотекой,
                    есть
                    разделы, в которых легко найти интересные новинки, бестселлеры и современную прозу.
                </p>
            </div>
            <div class=" ">
                <h2>2</h2>
                <p class="AdoutC2">
                    После простой регистрации вам будет доступна уникальная система достижений по просмотрам, лайкам и
                    комментариям
                    книг – теперь читать будет ещё интереснее! Также можно оставить отзыв о книге, вести диалог с
                    другими
                    читателями
                    и просмотреть карточку другого пользователя, нажав на его аватарку.
                </p>
            </div>
            <div class=" ">
                <h2>3</h2>
                <p> Вы можете читать фрагменты книг прямо на сайте, не загружая к себе на компьютер. А все отмеченные
                    книги
                    будут
                    отображаться в блоке «Избранное».
                </p>
            </div>
            <div class=" ">
                <h2>4</h2>
                <p> Для поиска интересующей литературы рекомендуем пользоваться поисковиком по сайту, расположенным в
                    нижней
                    части
                    страницы прямо посередине. Это самый простой и эффективный способ найти искомое: книгу, автора,
                    серию
                    книг.
                </p>
            </div>
            <div class=" ">
                <h2>5</h2>
                <p>
                    У каждой книги есть рейтинг, а также отзывы, опубликованные читателями библиотеки. Надеемся, Вы
                    сможете
                    найти
                    что-то интересное для себя!
                </p>
            </div>
        </div>
        <h2>Проект был создан и улучшен благодаря:</h2>
        <div class="AdoutUsers">
            <div class="AdoutUsersItem bc1 ">
                <img src="../../../static/img/help/2.jpg" alt="">
                <h4>Иван Ушаков 👾</h4>
                <h5>Создатель сайта</h5>
            </div>
            <div class="AdoutUsersItem bc">
                <img src="../../../static/img/help/1.jpg" alt="">
                <h4>Екатерина Габиева👸</h4>
                <h5>Написала текст на сайте</h5>
            </div>
            <div class="AdoutUsersItem bc2">
                <img src="../../../static/img/help/3.jpg" alt="">
                <h4>Владимир Владимирович🥷</h4>
                <h5>Подсказал новый функционал и всяческая помощь</h5>
            </div>
            <div class="AdoutUsersItem bc3">
                <img src="../../../static/img/help/4.jpg" alt="">
                <h4>Даниил Шаповалов 💣</h4>
                <h5>Тестирование и новый функционал</h5>
            </div>
        </div>
    </div>
</template>
<script>

export default {

}
</script>
<style lang="scss" scoped>
.bc {
    background: #db2973;
    color: white;

}

.bc1 {
    background: #0e0e0e;
    color: white;
}

.bc2 {
    background: #1c1c1c;
    color: white;
}

.bc3 {
    background: #294799;
    color: white;
}

.Adout {
    h1 {
        font-size: 2.5rem;
        margin: 20px 0;
    }

    h2 {
        font-size: 2.5rem;
        margin: 20px 0;
    }

    &Users {
        display: flex;
        flex-wrap: wrap;
        padding: 20px 0;
        gap: 20px;

        &Item {
            padding: 10px;
            border-radius: 15px;
            font-family: 'mm';
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: rgb(0 0 0 / 42%) 0 0 30px;
            flex: 1 1 350px;

            img {
                height: 100px;
                border-radius: 25px;
            }
        }
    }

    &Texts {
        display: flex;
        flex-direction: column;
        gap: 25px;

        div {
            display: flex;

            padding: 10px 0 0 0;
            flex: 1;


            align-items: flex-end;


            h2 {
                font-size: 2rem;
                color: rgb(0, 0, 0);
                margin: 0;

                padding-right: 10px;
            }

            p {
                font-size: 1.2rem;
                margin: 0;
                color: #000000;
                border-bottom: #24242441 solid 1px;
            }
        }


    }

}
</style>

