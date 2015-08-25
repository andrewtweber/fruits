</div>

<footer>

<a href="http://andrewtweber.com/" target="_blank"><span>&copy; {date('Y')} </span>Andrew Weber</a>
&bull; <a href="/about">About</a>
&bull; {if $smaller}<a href="/{$_PAGE['url']}?larger" rel="nofollow">Larger<span> Images</span></a>{else}<a href="/{$_PAGE['url']}?smaller" rel="nofollow">Smaller<span> Images</span></a>{/if}

{if $is_mobile}
<div id="add">
Add it to your Home screen!<br>
<img src="/images/add.png" width="33" height="27" alt="Add">
</div>
{/if}

</footer>

</body>
</html>
