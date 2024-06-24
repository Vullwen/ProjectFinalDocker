import tkinter as tk
from tkinter import messagebox
import requests

API_BASE_URL = "http://localhost/2A-ProjetAnnuel/PCS/API"


def fetch_tickets():
    try:
        response = requests.get(f"{API_BASE_URL}/tickets")
        response.raise_for_status()
        data = response.json()
        return data.get("data", [])
    except requests.RequestException as e:
        messagebox.showerror(
            "Erreur", f"Erreur lors de la récupération des tickets: {e}"
        )
        return []


def update_ticket_status(ticket_id, new_status):
    try:
        response = requests.patch(
            f"{API_BASE_URL}/tickets/{ticket_id}", json={"status": new_status}
        )
        response.raise_for_status()
        messagebox.showinfo("Succès", "Le statut du ticket a été mis à jour.")
        refresh_tickets()
    except requests.RequestException as e:
        messagebox.showerror("Erreur", f"Erreur lors de la mise à jour du ticket: {e}")


def refresh_tickets():
    for widget in tickets_frame.winfo_children():
        widget.destroy()
    tickets = fetch_tickets()
    for ticket in tickets:
        ticket_frame = tk.Frame(
            tickets_frame, borderwidth=1, relief="solid", padx=10, pady=10
        )
        tk.Label(ticket_frame, text=f"ID: {ticket['id']}").pack(anchor="w")
        tk.Label(ticket_frame, text=f"Catégorie: {ticket['categorie']}").pack(
            anchor="w"
        )
        tk.Label(ticket_frame, text=f"Description: {ticket['description']}").pack(
            anchor="w"
        )
        tk.Label(ticket_frame, text=f"Statut: {ticket['status']}").pack(anchor="w")

        btn_open = tk.Button(
            ticket_frame,
            text="Ouvrir",
            command=lambda t=ticket["id"]: update_ticket_status(t, "open"),
        )
        btn_closed = tk.Button(
            ticket_frame,
            text="Fermer",
            command=lambda t=ticket["id"]: update_ticket_status(t, "closed"),
        )

        btn_open.pack(side="left", padx=5)
        btn_closed.pack(side="left", padx=5)

        ticket_frame.pack(fill="x", pady=5)


root = tk.Tk()
root.title("Dashboard de Ticketing")

main_frame = tk.Frame(root)
main_frame.pack(fill="both", expand=True, padx=20, pady=20)

header_frame = tk.Frame(main_frame)
header_frame.pack(fill="x", pady=10)

tk.Label(header_frame, text="Liste des Tickets", font=("Arial", 18)).pack(side="left")
tk.Button(header_frame, text="Nouveau Ticket").pack(side="right")

refresh_btn = tk.Button(header_frame, text="Rafraîchir", command=refresh_tickets)
refresh_btn.pack(side="right")

tickets_frame = tk.Frame(main_frame)
tickets_frame.pack(fill="both", expand=True, pady=10)

refresh_tickets()

root.mainloop()
