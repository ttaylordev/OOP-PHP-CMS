<form class="form-signin" action="index.php" method="post">

    <input type="hidden" name="section" value="contact">
    <input type="hidden" name="action" value="submitContactForm">

    <div class="text-center mb-4">
        <h1 class="h3 mb-3 font-weight-normal">
            <?php echo $pageObj->title;?>
        </h1>

        <p>
            <?php echo $pageObj->content;?>
        </p>
    </div>

    <div class="form-label-group">
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" value="" required autofocus>
        <label for="inputEmail">Email address</label>
    </div>

    <div class="form-label-group">
        <textarea id="comment" class="form-control" name="comment" ></textarea>
        <label for="inputPassword">Message</label>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Send</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2020</p>
</form>