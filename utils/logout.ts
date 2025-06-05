// src/utils/logout.ts
export async function logout(router: any) {
  await fetch("http://localhost:8000/auth/logout.php", {
    method: "POST",
    credentials: "include",
  });
  router.push("/espace-pro/login");
}
