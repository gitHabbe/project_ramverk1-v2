<?php

namespace Anax\View;

// var_dump($tags);
// die();

?>

<div>
    <form action="<?= $this->di->url->create("thread/new") ?>" method="post">
        <label for="topic">Topic</label><input type="text" name="topic">
        <select name="tag" id="tag-select">
            <option value=""></option>
            <?php foreach ($tags as $tag) : ?>
                <option id="<?= $tag->name ?>" value="<?= $tag->name ?>"><?= $tag->name ?></option>
            <?php endforeach; ?>
        </select>
        <input readonly onkeydown="return false;" type="text" name="tags" id="tags">
        <button id="clear-tags">Clear tags</button>
        <br>
        <label for="content">Content</label>
        <textarea type="text" name="content"></textarea>
        <button type="submit">Create thread</button>
    </form>
</div>


<script>

var select = document.querySelector("#tag-select");
select.addEventListener("change", onChange);
var tags = document.getElementById("tags");
var clearBtn = document.querySelector("#clear-tags");
clearBtn.addEventListener("click", clear);

function onChange(e) {
    var option = document.querySelector("#" + e.target.value);
    tags.value += "#" + e.target.value + " ";
    console.log("selected", e.target.value)
    select.removeChild(option);
}

function clear(e) {
    e.preventDefault();
    tags.value = "";
    var select = document.querySelector("#tag-select");
    select.innerHTML = "";
    select.appendChild(document.createElement("option"));
    <?php foreach ($tags as $tag) : ?>
        var newOption = document.createElement("option");
        newOption.id = "<?= $tag->name ?>";
        newOption.value = "<?= $tag->name ?>";
        newOption.text = "<?= $tag->name ?>";
        console.log(newOption)
        select.appendChild(newOption);
    <?php endforeach; ?>
}
</script>