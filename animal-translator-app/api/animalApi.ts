export async function getAllAnimals() {
  const res = await fetch("http://172.21.154.62/test/rest-api/api.php?endpoint=animal&action=read");
  if (!res.ok) throw new Error("Failed to load animals");
  return await res.json();
}
