<?php
class WPygmentsAdmin
{

    /**
     * @param Pygmentizer $pygments
     * return string
     * @todo add detect pygments and show instructions to user to fix it
     */
    static function adminPage($pygments)
    {

        $styles_options = "";
        $default_style = "default";

        foreach ($pygments->getStyles() as $style) {
            $option = '<option value="' . $style . '"';
            if ($style == $default_style) $option .= ' selected="selected" ';
            $option .= '>' . $style . '</option>';
            $styles_options .= $option;
        }
        /////////////////////////////////
        ?>


    <form action="">
        <br>

        <div>
            <label>
                Default style
                <select class="select" name="style" id="style">
                    <?=$styles_options?>
                </select>
                <br>
                <span class="desc">Used when you dont specify a style<br> <a
                        href="https://github.com/capy/WPygments#color-styles">see here available styles</a></span>
            </label>
        </div>
        <br>

        <div>
            <label>
                <input type="checkbox" name="linenumbers" value="linenumbers">
                Use line numbers
            </label>
        </div>


    </form>


    <?php
        /////////////////////////////////
    }
}

?>