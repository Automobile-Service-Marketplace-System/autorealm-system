<?php

/**
 * @var bool $is_authenticated
 */
?>

<section class="home-section container" id="our-services" style="margin-top: -2rem">
    <h2 style="margin-top: 1rem">Our Services</h2>
    <article>
        <img src="/images/article-image-1.jpg" alt="Article image 1">
        <div>
            <h3>Fluid Replacement</h3>
            <p>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Molestias tempora tenetur eius! Iure facilis
                ea praesentium facere minima illo dolore veritatis asperiores aspernatur, eum iusto nisi eligendi,
                voluptatibus quis. Adipisci consequuntur, deserunt quia enim doloribus cupiditate repellendus fugit
                porro provident maxime sed blanditiis minima aut recusandae mollitia eveniet id unde nobis similique ex
                labore consequatur error voluptate! Esse officiis qui, tenetur dolorum inventore consequatur iure
                necessitatibus aliquid soluta molestias labore in, pariatur tempora aspernatur reprehenderit at odit
                incidunt veritatis saepe doloribus atque ipsam nemo unde. Quaerat quam accusamus maxime amet nihil fuga
                placeat delectus ipsa? Est laudantium sed iure dolorem.
            </p>
        </div>
    </article>
    <article>
        <div>
            <h3>Tyres & Wheel Grooming</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Reprehenderit saepe a vel. Aut eveniet fugit
                quis maxime quo excepturi nisi natus commodi optio? Enim magnam saepe beatae alias necessitatibus porro
                ducimus exercitationem accusamus ex dolorum pariatur consequuntur, rem eius qui ipsum voluptatum ipsa
                quod commodi blanditiis, nostrum deserunt? Cupiditate optio quo itaque, earum velit consequuntur unde
                nulla quisquam nostrum numquam veritatis tenetur laudantium voluptas, doloremque accusamus, quidem
                voluptate sit fugiat. Dicta qui praesentium tempora harum quisquam commodi minima reprehenderit placeat
                quia provident. Alias similique tempora ducimus fugiat eius aliquid, officiis repellendus quo iste
                dolorum id consequatur rem quam inventore debitis?
            </p>
        </div>
        <img src="/images/article-image-2.jpg" alt="Article image 2">
    </article>
    <article>
        <img src="/images/article-image-3.jpg" alt="Article image 3">

        <div>
            <h3>Headlight Replacement</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut praesentium commodi modi culpa fugit libero
                eligendi, exercitationem voluptate rem quam molestiae, eaque officiis rerum delectus. Obcaecati ut
                exercitationem ullam cum iure quae aut recusandae natus molestiae alias doloremque perferendis nemo,
                amet sapiente quas voluptatibus eveniet commodi officiis sequi! Cum eveniet ipsa quod blanditiis quas
                fuga hic sapiente inventore facere deserunt similique temporibus ex id illo, iste debitis eaque,
                repellendus beatae placeat rerum quo? Ex nesciunt molestiae quo. Doloremque quam, dignissimos quo
                tempore rerum unde adipisci, sit recusandae nulla cupiditate aspernatur quasi voluptatem delectus sequi
                a impedit minus aliquam iure dolorum?

            </p>
        </div>
    </article>
</section>
<?php
if($is_authenticated) {
    echo "<div class='flex items-center justify-center'>
            <a href='/dashboard/appointments' class='btn btn--danger '>Get an appointment</a>
          </div>";
}
?>

