<?php
if (!session_id()) {
    session_start();
}

require_once __DIR__ . "/language.php";
require_once __DIR__ . "/libs/redirect.class.php";
require_once __DIR__ . "/view/template/header/normal.php";

use Redirect\Redirect as Redirect;


// if (empty($_SESSION['userDM'])) {
//     new Redirect('login.php');
// }

$title   = $lang["title"];


$Conn = new Database;
$optionAreas = $optionShops = $optionMeet = "";

$query = "SELECT DISTINCT * FROM SoriContents_List ORDER BY 画像1 DESC";
$stmt = $Conn->conn->prepare($query);
$stmt->execute();
$resultTest = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<img id="scloading" style="position: absolute; right: 42%; top: 500px; z-index: 9999; background-color: rgb(51, 51, 51); padding: 2%;" src="assets/images/icon_loading.gif">

<!-- modal delete -->
<div class="modal fade" id="modalDel" data-backdrop="static" data-keyboard="false" data-toggle="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <!-- <div class="modal-header">
                <p class="heading lead">Modal Danger</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div> -->

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <p class="message">地区を削除してよろしいでしょうか？</p>
                    <p class="btnCenter">
                        <button id="submit_del_ok" class="btnDel btnDel_a" onclick="location.reload()" style=' display:none'>OK</button>
                        <!-- get value from onclick onclick="testDel(this.id)" -->
                        <button name="btnDel_a" id="submit_del" onclick="deletecontent(this.value)" value="" class="btnDel btnDel_a">はい</button>
                        <a title="Close" id="btnCloseFc" class="btn btnClose" href="javascript:;" data-dismiss="modal">いいえ</a>
                    </p>
                </div>
            </div>
            </section>

        </div>
    </div>

</div>
<!-- modal delete -->



<!-- modal include show table create and update -->
<!-- class input when opendialog then delete data  -->
<!-- Central Modal Medium Danger -->
<div class="modal fade" id="centralModalDanger" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <!-- <div class="modal-header"><p class="heading lead">Modal Danger</p><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="white-text">&times;</span></button></div> -->
            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col">
                            <h2 class="h2Title">
                                <span><?= $lang['title'] ?></span>
                            </h2>
                        </div>
                        <div class="col">
                            <button type="button" style="border: 5px solid black;" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                    <hr style="height:3px; background-color: #b4b4b4;">
                    <img class="dialogLoading" src="assets/images/icon_loading.gif" />
                    <div class="frmSection">
                        <div class="error error_inline0 pb0">
                            <p>&nbsp;</p>
                        </div>
                        <div class="show_parent">
                            <!-- 公開フラグ, カテゴリーNo., 短縮タイトル, 正式タイトル, 解説, アラートメッセージ, コメント, リンク先URL, 別ウィンドウ区分, 画像1, 画像2, 
                        TOP非表示, FREE, 簿記9, 簿記10, 簿記11, JA9, JA10, JA11, JA接続キット, 日誌6, 日誌6P -->
                            <form action="" accept-charset="utf-8">
                                <table cellpadding="0" cellspacing="0" class="dialogCreate">
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>公開フラグ</span><img class="show_pc" src="./assets/images/content/hissu_12px.gif" alt="必須項目" style="display: inline-block;">
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" name="flagContent" id="flagContent"> -->
                                                    <select class="browser-default custom-select" name="flagContent" id="flagContent" style="width: 40%; text-align-last: center;">
                                                        <option selected="" value="0">0</option>
                                                        <option value="1">1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>カテゴリーNo</span><img class="show_pc" src="./assets/images/content/hissu_12px.gif" alt="必須項目" style="display: inline-block;">
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" name="cateContent" id="cateContent"> -->

                                                    <!-- update -->
                                                    <select class="browser-default custom-select" name="cateContent" id="cateContent" style="width: 40%; text-align-last: center;">
                                                        <option selected="" value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                    <!-- update -->

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
                                            <div class="row">
                                                <div class="col-2">
                                                    <span>短縮タイトル</span><img class="show_pc" src="./assets/images/content/hissu_12px.gif" alt="必須項目" style="display: inline-block;">
                                                </div>
                                                <div class="col-10">
                                                    <textarea type="text" rows="2" cols="50" class="input w-100" name="shortTittleContent" id="shortTittleContent"></textarea>
                                                </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
                                            <div class="row">
                                                <div class="col-2">
                                                    <span>正式タイトル</span><img class="show_pc" src="./assets/images/content/hissu_12px.gif" alt="必須項目" style="display: inline-block;">
                                                </div>
                                                <div class="col-10">
                                                    <textarea type="text" rows="2" cols="50" class="input w-100" name="longTittleContent" id="longTittleContent"></textarea>
                                                </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
                                            <div class="row">
                                                <div class="col-2">
                                                    <span>解説</span><img class="show_pc" src="./assets/images/content/hissu_12px.gif" alt="必須項目" style="display: inline-block;">
                                                </div>
                                                <div class="col-10">
                                                    <textarea type="text" rows="2" cols="50" class="input w-100" name="notifyContent" id="notifyContent"></textarea>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
                                            <div class="row">
                                                <div class="col-2">
                                                    <span>アラートメッセージ</span>
                                                </div>
                                                <div class="col-10">
                                                    <!-- <input type="text" class="input" id="alertContent"> -->
                                                    <textarea type="text" rows="2" cols="50" class="input w-100" name="alertContent" id="alertContent"></textarea>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
                                            <div class="row">
                                                <div class="col-2">
                                                    <span>コメント</span>
                                                </div>
                                                <div class="col-10">
                                                    <!-- <input type="text" class="input" id="commentContent"> -->
                                                    <textarea type="text" rows="2" cols="50" class="input w-100" name="commentContent" id="commentContent"></textarea>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
                                            <div class="row">
                                                <div class="col-2">
                                                    <span>リンク先URL</span><img class="show_pc" src="./assets/images/content/hissu_12px.gif" alt="必須項目" style="display: inline-block;">
                                                </div>
                                                <div class="col-10">
                                                    <input type="text" style="width: 100%;" class="input" name="linkContent" id="linkContent">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>画像1</span><img class="show_pc" src="./assets/images/content/hissu_12px.gif" alt="必須項目" style="display: inline-block;">
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="input" name="image1Content" id="image1Content" disabled>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>画像2</span>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="input" name="image2Content" id="image2Content">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>別ウィンドウ区分</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="topContent"> -->
                                                    <select class="browser-default custom-select" name="seperateContent" id="seperateContent" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="1">1</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </td>

                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>TOP非表示</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="topContent"> -->
                                                    <select class="browser-default custom-select" name="topContent" id="topContent" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="1">1</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>FREE</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="freeContent"> -->
                                                    <select class="browser-default custom-select" name="freeContent" id="freeContent" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                        <option value="alert">ALERT</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>簿記9</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="account9Content"> -->
                                                    <select class="browser-default custom-select" name="account9Content" id="account9Content" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>簿記10</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="account10Content"> -->
                                                    <select class="browser-default custom-select" name="account10Content" id="account10Content" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>簿記11</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="account11Content"> -->
                                                    <select class="browser-default custom-select" name="account11Content" id="account11Content" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>JA9</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="account9Content"> -->
                                                    <select class="browser-default custom-select" name="JA9Content" id="JA9Content" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>JA10</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="account10Content"> -->
                                                    <select class="browser-default custom-select" name="JA10Content" id="JA10Content" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>JA11</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" id="account11Content"> -->
                                                    <select class="browser-default custom-select" name="JA11Content" id="JA11Content" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>JA接続キット</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" name="JAContent" id="JAContent"> -->
                                                    <select class="browser-default custom-select" name="JAContent" id="JAContent" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>日誌6</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" name="diary6Content" id="diary6Content"> -->
                                                    <select class="browser-default custom-select" name="diary6Content" id="diary6Content" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>日誌6P</span>
                                                </div>
                                                <div class="col-8">
                                                    <!-- <input type="text" class="input" name="diary6PContent" id="diary6PContent"> -->
                                                    <select class="browser-default custom-select" name="diary6PContent" id="diary6PContent" style="width: 50%; text-align-last: center;">
                                                        <option selected="" value="">NULL</option>
                                                        <option value="ok">OK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- <tr><td colspan="2"><div class="row"><div class="col-4"><span>JA9</span></div><div class="col-8"><input type="text" class="input" id="JA9Content"><span></div></div></td><td colspan="2"><div class="row"><div class="col-4"><span>JA10</span></div><div class="col-8"><input type="text" class="input" id="JA10Content"><span></div></div></td><td colspan="2"><div class="row"><div class="col-4"><span>JA11</span></div><div class="col-8"><input type="text" class="input" id="JA11Content"><span></div></div></td></tr> -->
                        </div>
                    </div>
                    </table>
                    </form>
                </div>
                <p class="center">
                    <input type="hidden" id="possiton" />
                    <input type="submit" name="submit_ud" id="submit_ud" value="submit" onclick="savecontent()" style="width: 150px; font-size: 15px;" />
                    <!-- <a title="Close" class="btn btnClose" href="javascript:;" onclick="" style="width: 150px; font-size: 15px;">キャンセル</a> -->
                    <a title="Close" id="btnCloseFc" class="btn btnClose" href="javascript:;" style="width: 150px; font-size: 15px; padding: 11px;" data-dismiss="modal">キャンセル</a>
                    <!-- <a title="Close" class="btn btnClose" href="javascript:;" onclick="$.fancybox.close();" style="width: 150px; font-size: 15px;">キャンセル</a> -->
                </p>
            </div>
            </section>
        </div>
    </div>
</div>
<!--/.Content-->
</div>
</div>
<!-- Central Modal Medium Danger-->


<!-- show listData -->
<article id="main" class="clearfix">
    <img id="scLoading" style="position:absolute; right:42%; top:500px; z-index:9999; display:none; background-color:#333; padding:2%;" src="assets/images/icon_loading.gif" />
    <section id="main_content">
        <div class="boxStyle02">
            <div class="clearfix" style="text-align: justify;vertical-align: middle;">
                <p class="contentTitle pb0"> <span><?= $lang["title"] ?></span> </p>
                <div class="contentCon">
                    <p class="fRight right pb0">
                        <button type="button" class="btn btn-primary" onclick="openDialog(this.id,false);" data-toggle="modal" data-target="#centralModalDanger"><?= $lang["add"] ?></button>
                    </p>
                </div>

                <p class="contentSe1" style="float:left; width:100%; text-align:center;">
                    <label id="inputExcel"></label>
                </p>
            </div>
            <!-- Content -->
            <table id="table_idTest" class="display">
                <thead>
                    <tr>
                        <!-- 公開フラグ, カテゴリーNo., 短縮タイトル, 正式タイトル, 
                        解説, アラートメッセージ, コメント, リンク先URL, 別ウィンドウ区分, 画像1, 画像2,
                         TOP非表示, FREE, 簿記9, 簿記10, 簿記11, JA9, JA10, JA11, JA接続キット, 日誌6, 日誌6P -->
                        <th style="width:2%;"><span>画像1</span></th>
                        <th style="width:2%;"><span>公開フラグ</span></th>
                        <th style="width:3%;"><span>カテゴリーNo.</span></th>
                        <th style="width:4%;"><span>短縮タイトル</span></th>
                        <th style="width:4%;"><span>正式タイトル</span></th>
                        <th style="width:10%;"><span>解説</span></th>
                        <th style="width:10%;"><span>アラートメッセージ</span></th>
                        <th style="width:4%;"><span>コメント</span></th>
                        <th style="width:10%;"><span>リンク先URL</span></th>
                        <th style="width:2%;"><span>別ウィンドウ区分</span></th>
                        <th style="width:2%;"><span>画像2</span></th>
                        <th style="width:3%;"><span>TOP非表示</span></th>
                        <th style="width:3%;"><span>FREE</span></th>
                        <th style="width:2%;"><span>簿記9</span></th>
                        <th style="width:2%;"><span>簿記10</span></th>
                        <th style="width:2%;"><span>簿記11</span></th>
                        <th style="width:3%;"><span>JA9</span></th>
                        <th style="width:3%;"><span>JA10</span></th>
                        <th style="width:3%;"><span>JA11</span></th>
                        <th style="width:2%;"><span>JA接続キット</span></th>
                        <th style="width:2%;"><span>日誌6</span></th>
                        <th style="width:2%;"><span>日誌6P</span></th>
                        <th style="width:3%;"><span>操作</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultTest as $key => $value) { ?>
                        <tr>
                            <td id="<?= $value["画像1"] ?>"><?= $value['画像1'] ?></td>
                            <td id="<?= $value["公開フラグ"] ?>"><?= $value['公開フラグ'] ?></td>
                            <td id="<?= $value["カテゴリーNo."] ?>"><?= $value['カテゴリーNo.'] ?></td>
                            <td id="<?= $value["短縮タイトル"] ?>"><?= $value['短縮タイトル'] ?></td>
                            <td id="<?= $value["正式タイトル"] ?>"><?= $value['正式タイトル'] ?></td>
                            <td id="<?= $value["解説"] ?>"><?= $value['解説'] ?></td>
                            <td id="<?= $value["アラートメッセージ"] ?>"><?= $value['アラートメッセージ'] ?></td>
                            <td id="<?= $value["コメント"] ?>"><?= $value['コメント'] ?></td>
                            <td style=" word-break: break-word;" id="<?= $value["リンク先URL"] ?>"><?= $value['リンク先URL'] ?>
                            <td id="<?= $value["別ウィンドウ区分"] ?>"><?= $value['別ウィンドウ区分'] ?></td>
                            <td id="<?= $value["画像2"] ?>"><?= $value['画像2'] ?></td>
                            <td id="<?= $value["TOP非表示"] ?>"><?= $value['TOP非表示'] ?></td>
                            <td id="<?= $value["FREE"] ?>"><?= $value['FREE'] ?></td>
                            <td id="<?= $value["簿記9"] ?>"><?= $value['簿記9'] ?></td>
                            <td id="<?= $value["簿記10"] ?>"><?= $value['簿記10'] ?></td>
                            <td id="<?= $value["簿記11"] ?>"><?= $value['簿記11'] ?></td>
                            <td id="<?= $value["JA9"] ?>"><?= $value['JA9'] ?></td>
                            <td id="<?= $value["JA10"] ?>"><?= $value['JA10'] ?></td>
                            <td id="<?= $value["JA11"] ?>"><?= $value['JA11'] ?></td>
                            <td id="<?= $value["JA接続キット"] ?>"><?= $value['JA接続キット'] ?></td>
                            <td id="<?= $value["日誌6"] ?>"><?= $value['日誌6'] ?></td>
                            <td id="<?= $value["日誌6P"] ?>"><?= $value['日誌6P'] ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btnEdit" id="<?= $value["画像1"] ?>" onclick="openDialog(this.id,true);" data-toggle="modal" data-target="#centralModalDanger"><?= $lang["edit"] ?></button>
                                <button name="btnConfirmDel" onclick="testDel(this.value)" value="<?= $value["画像1"] ?>" class="btnDel btnConfirmDel btnConfirm1" data-toggle="modal" data-target="#modalDel"><?= $lang["delete"] ?></button>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>


            <input type="hidden" id="scId">
            <input type="hidden" id="isEdit">
            <input type="hidden" id="oldPdf">
    </section>
</article>
<!-- show listData -->

<?php require_once __DIR__ . "/view/template/footer/normal.php"; ?>

<!-- properties language datatable -->
<script>
    $(document).ready(function() {
        $('#table_idTest').DataTable({
            "order": [
                [0, "desc"]
            ],
            searchDelay: 500,
            "lengthMenu": [
                [25, 50, -1],
                [25, 50, "全て"]
            ],

            "language": {
                "decimal": "",
                "emptyTable": "<?= $lang["emptyTable"] ?>",
                "info": "<?= $lang["info"] ?>",
                "infoEmpty": "<?= $lang["infoEmpty"] ?>",
                "infoFiltered": "",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?= $lang["lengthMenu"] ?>",
                "loadingRecords": "<?= $lang["loadingRecords"] ?>",
                "processing": "<?= $lang["processing"] ?>",
                "search": "<?= $lang["search"] ?>",
                "zeroRecords": "<?= $lang["zeroRecords"] ?>",
                "paginate": {
                    "first": "<?= $lang["first"] ?>",
                    "last": "<?= $lang["last"] ?>",
                    "next": "<?= $lang["next"] ?>",
                    "previous": "<?= $lang["previous"] ?>"
                },
                "aria": {
                    "sortAscending": "",
                    "sortDescending": ""
                }
            }
        });
    });
</script>

<!-- proccess add,edit,delete -->
<script type="text/javascript" src="assets/js/proccess/P_content.js"></script>

<script>
    $(document).ready(function() {
        $('#scloading').hide();
    });
</script>