<?php
  // �O���[�o���i�r�A�y�уT�C�g�S�ʂɊւ���L�q�ł��B
  // ���̖��ߍ��݂��g�p����ۂɂ͕K�� HeaderSelectNo �̒l��錾���Ă��Ă��������B
  // 20120830�ύX �w�b�_�[�錾���e�y�[�W����폜���܂��B
  $HPCategoryColor1 = "#3C4EAB";
  $HPCategoryColor2 = "b";

  // ������t�@�C���iindex.asp�t�@�C����p�j���i�[����Ă���
  // �t�H���_�����擾���܂��B
  // ����Ƀj���[�X�����[�X�̃t�H���_���擾�Ɏg�p���܂��B
  function GetLastFolderName() {
      $dir = scandir($_SERVER["SCRIPT_NAME"], 1);
      return $dir[0];
  }

  // �y�[�W�́u�O�ցv�u���ցv�̃f�U�C�����ꊇ���䂵�܂��B
  // ���Ɩ��ł��_�Ƃł��g�p���Ă��܂��̂Œ��ӂ��Ă��������B
  function PrevNextNaviAg($direct, $prevurl, $prevpage, $nexturl, $nextpage) { 
    $color = (strtolower($direct) == "next") ? 'E0E4FF' : '#F4F4F8';?>
    <DIV style="margin-bottom:1em; padding:5px 0px 4px 0px; border-top:1px #C0C0C0 solid; border-bottom:1px #C0C0C0 solid; background-color:<?= $color ?>; text-align:center;">
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TR>
          <TD class="prd_g_pgback"><A href="<?= $prevurl ?>"><?= $prevpage ?></A></TD>
          <TD class="prd_g_pgnext" style="text-align:right;"><A href="<?= $nexturl ?>"><?= $nextpage ?></A></TD>
        </TR>
      </TABLE>
    </DIV>
<?php
  } ?>
