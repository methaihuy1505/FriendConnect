<div class="tab-pane fade" id="edit">
    <h3>Chỉnh sửa hồ sơ</h3>
    <div class="profile-form profile-form-inner">
        <div class="container ">
            <form id="editProfileForm" action="index.php?c=user&a=update" method="POST" enctype="multipart/form-data"
                class="mt-3">
                <?php $prefix = 'edit';
                $user                         = $currentUser; ?>

                <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                <!-- Ảnh đại diện -->
                <?php require "layout/profile/field_avatar.php"; ?>
                <!-- Tên -->

                <?php require "layout/profile/field_name.php"; ?>


                <!-- Email -->
                <?php require "layout/profile/field_email.php"; ?>


                <!-- Ngày sinh -->
                <?php require "layout/profile/field_birthdate.php"; ?>



                <!-- Giới tính -->
                <?php require "layout/profile/field_gender.php"; ?>


                <!-- Quan tâm đến -->
                <?php require "layout/profile/field_interested_in.php"; ?>


                <!-- Tìm kiếm -->
                <?php require "layout/profile/field_relationship_intent.php"; ?>





                <!-- Sở thích -->
                <?php require "layout/profile/field_interests.php"; ?>


                <!-- Xu hướng tính dục -->
                <?php require "layout/profile/field_orientation.php"; ?>



                <button type="submit" class="btn btn-primary">
                    Lưu thay đổi
                </button>
            </form>
        </div>
    </div>
</div>