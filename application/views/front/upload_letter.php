<div class="col-md-8 info">

    <div class="inner-info">
        <h3>
            <?= $title ?>
        </h3>
        <p class="sub-string" style="margin-bottom:10px;margin-top:10px;">
            In accordance with the law "Informatique et Liberte" of January 6, 1978, you have a right to access, modify, rectify and delete date concerning you.
        </p>

        <b class="sub-string" style="color:red;margin-bottom:10px;margin-top:10px;">
            <?= $error?>
        </b>


        <form action="<?= $url ?>" id="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="row">
                <div class="col-md-12">


                    <div class="form-group">
                        <div class="form-group">

                            <input type="file" required name="<?= $filename ?>" class="form-control"  placeholder="<?= $title ?>">
                        </div>
                    </div>



                </div>
            </div>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="float: right;">
                save
            </button>

        </form>
    </div>
</div>