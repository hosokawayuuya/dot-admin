const character = document.getElementById("character");
const buildings = document.querySelectorAll(".building");

character.style.top = "50%";
character.style.left = "50%";

document.addEventListener("keydown", moveCharacter);

function moveCharacter(event) {
  const speed = 10;
  const currentPosition = {
    x: parseInt(character.style.left),
    y: parseInt(character.style.top)
  };

  switch (event.key) {
    case "ArrowUp":
      character.style.top = `${currentPosition.y - speed}px`;
      break;
    case "ArrowDown":
      character.style.top = `${currentPosition.y + speed}px`;
      break;
    case "ArrowLeft":
      character.style.left = `${currentPosition.x - speed}px`;
      break;
    case "ArrowRight":
      character.style.left = `${currentPosition.x + speed}px`;
      break;
  }

  checkCollision();
}

function checkCollision() {
  const characterRect = character.getBoundingClientRect();

  buildings.forEach(building => {
    const buildingRect = building.getBoundingClientRect();

    if (
      characterRect.left < buildingRect.right &&
      characterRect.right > buildingRect.left &&
      characterRect.top < buildingRect.bottom &&
      characterRect.bottom > buildingRect.top
    ) {
      alert("You've reached a building!");
      // 建物に到達したら遷移する処理
      window.location.href = "新しいページのURL"; // 新しいページのURLを指定してください
    }
  });
}
