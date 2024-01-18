<template>
<editor
:api-key="tinymce_api_key"
:init="{
    height: '50rem',
    menubar: true,
    language: 'ja',
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
    toolbar1: 'aligncenter alignjustify alignleft alignnone alignright| anchor | blockquote blocks | backcolor | bold | copy | cut | fontfamily fontsize forecolor h1 h2 h3 h4 h5 h6 hr indent | italic | language | lineheight | newdocument | outdent | paste pastetext | print | redo | remove removeformat | selectall | strikethrough | styles | subscript superscript underline | undo | visualaid | a11ycheck advtablerownumbering typopgraphy anchor restoredraft casechange charmap checklist code codesample addcomment showcomments ltr rtl editimage fliph flipv imageoptions rotateleft rotateright emoticons export footnotes footnotesupdate formatpainter fullscreen help image insertdatetime link openlink unlink bullist numlist media mergetags mergetags_list nonbreaking pagebreak pageembed permanentpen preview quickimage quicklink quicktable cancel save searchreplace spellcheckdialog spellchecker | table tablecellprops tablecopyrow tablecutrow tabledelete tabledeletecol tabledeleterow tableinsertdialog tableinsertcolafter tableinsertcolbefore tableinsertrowafter tableinsertrowbefore tablemergecells tablepasterowafter tablepasterowbefore tableprops tablerowprops tablesplitcells tableclass tablecellclass tablecellvalign tablecellborderwidth tablecellborderstyle tablecaption tablecellbackgroundcolor tablecellbordercolor tablerowheader tablecolheader | tableofcontents tableofcontentsupdate | template typography | insertfile | visualblocks visualchars | wordcount',
}"
v-model="textarea"
/>
</template>
<script setup lang="ts">
import Editor from '@tinymce/tinymce-vue';

const textarea = ref('');
const config = useRuntimeConfig();
const tinymce_api_key = ref('');
tinymce_api_key.value = config.public.TINYMCE_API_KEY;

const getTextAreaValue = (): string =>
{
    return textarea.value;
}

const setTextAreaValue = (value: string) =>
{

    textarea.value = value;

}

defineExpose(
{
    getTextAreaValue,
    setTextAreaValue
});
</script>