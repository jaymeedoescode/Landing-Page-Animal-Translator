import { BASE_URL } from '../constants/api';

const API_BASE = `${BASE_URL}/rest-api/index.php?endpoint=animal`;

// GET all animals
export async function getAllAnimals() {
  const res = await fetch(`${API_BASE}&action=read`);
  return await res.json();
}

// GET one animal by ID
export async function getAnimalById(id: string | number) {
  const res = await fetch(`${API_BASE}&action=read_single&id=${id}`);
  return await res.json();
}

// UPDATE an animal
export async function updateAnimal(id: string | number, animal: string, translation: string) {
  const res = await fetch(`${API_BASE}&action=update`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id, animal, translation }),
  });
  return await res.json();
}
