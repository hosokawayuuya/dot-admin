document.addEventListener('keydown', function(event) {
    const character = document.getElementById('character');
    const characterRect = character.getBoundingClientRect();
    let newTop = characterRect.top;
    let newLeft = characterRect.left;

    // キーの押下に応じて新しい位置を計算
    switch(event.key) {
        case 'ArrowUp':
            newTop = Math.max(0, characterRect.top - 10);
            break;
        case 'ArrowDown':
            newTop = Math.min(0, characterRect.top + 10);
            break;
        case 'ArrowLeft':
            newLeft = Math.max(0, characterRect.left - 10);
            break;
        case 'ArrowRight':
            newLeft = Math.min(0, characterRect.left + 10);
            break;
    }

    // キャラクターの位置を更新
    character.style.top = newTop + 'px';
    character.style.left = newLeft + 'px';

    // キャラクターがオブジェクトに入ったかどうかの判定
    checkCollision();
});

function checkCollision() {
    const character = document.getElementById('character');
    const characterRect = character.getBoundingClientRect();
    const objects = document.querySelectorAll('.object');

    objects.forEach(object => {
        const objectRect = object.getBoundingClientRect();
        if (
            characterRect.top < objectRect.bottom &&
            characterRect.bottom > objectRect.top &&
            characterRect.left < objectRect.right &&
            characterRect.right > objectRect.left
        ) {
            // キャラクターがオブジェクトに入った場合の処理
            console.log('Character entered object: ' + object.id);
        }
    });
}
