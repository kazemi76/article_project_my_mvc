<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">

    <?php require APPROOT . '/views/inc/navbar.php' ?>

    <div class="row">

        <div class="col-md-7 mx-auto">

            <div class="card">
            <?php echo flash('article_message') ?>
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <h5>ایجاد مقاله</h3>
                        <a href="<?php echo URLROOT; ?>/articles/index" class="btn btn-dark btn-sm" >
                            بازگشت
                        </a>
                    </div>

                    <hr class="mt-0">

                    <form action="<?php echo URLROOT; ?>/articles/add" method="post">

                        <div class="form-group">
                            <label for="title"> عنوان مقاله <sup>*</sup> </label>
                            <input type="title" name="title" class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                            <span class="invalid-feedback"> <?php echo $data['title_err'] ?> </span>
                        </div>

                        <div class="form-group">
                            <label for="text"> متن مقاله <sup>*</sup> </label>
                            <textarea type="text" name="text" class="form-control <?php echo (!empty($data['text_err'])) ? 'is-invalid' : ''; ?>"> <?php echo $data['text']; ?> </textarea>
                            <span class="invalid-feedback"> <?php echo $data['text_err'] ?> </span>
                        </div>

                        <div class="text-center my-4">
                            <button class="btn btn-dark" type="submit"> ایجاد </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <?php require APPROOT . '/views/inc/footer.php'; ?>