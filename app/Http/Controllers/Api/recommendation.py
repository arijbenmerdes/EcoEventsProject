import requests
import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.preprocessing import MultiLabelBinarizer

url = 'http://127.0.0.1:8000/ai/export-data'
response = requests.get(url)
print(response.status_code)
print(response.headers.get('Content-Type'))
print(response.text[:500]) 

if response.status_code != 200:
    print(f"Erreur API : {response.status_code}")
    print(response.text)
    exit()

try:
    data = response.json()
except ValueError:
    print("Erreur : la réponse n'est pas au format JSON")
    print(response.text)
    exit()

events = data['events']  # prends uniquement les événements
events_df = pd.DataFrame(events)

# Vérifie qu'il y a la colonne preferred_categories
if 'preferred_categories' not in events_df.columns:
    print("Erreur : la colonne 'preferred_categories' est manquante")
    exit()

# Transformer les catégories en variables binaires
mlb = MultiLabelBinarizer()
category_matrix = mlb.fit_transform(events_df['preferred_categories'])

# Profil utilisateur exemple
user_profile = ["musique", "gratuit"]
user_vector = mlb.transform([user_profile])

# Calcul similarité cosinus
similarity = cosine_similarity(user_vector, category_matrix)
events_df['score'] = similarity[0]

# Trier par score décroissant
recommended_events = events_df.sort_values(by='score', ascending=False)

print("Événements recommandés pour l'utilisateur :")
print(recommended_events[['title', 'preferred_categories', 'score']])
