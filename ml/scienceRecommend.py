import pandas as pd
from sklearn.model_selection import train_test_split, GridSearchCV
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score
from sklearn.preprocessing import StandardScaler
from sklearn.pipeline import Pipeline
import joblib
import os 
import sys

def load_data(file_path):
    return pd.read_csv(file_path)

def preprocess_data(data):
    X = data.drop(columns=['Role'])
    y = data['Role']
    return X, y

def train_model(X_train, y_train, model_filename):
    pipeline = Pipeline([
        ('scaler', StandardScaler()),
        ('rf', RandomForestClassifier(random_state=42))
    ])
    
    parameters = {
        'rf__n_estimators': [100, 200, 300],
        'rf__max_depth': [None, 10, 20],
        'rf__min_samples_split': [2, 5, 10],
        'rf__min_samples_leaf': [1, 2, 4]
    }

    clf = GridSearchCV(pipeline, parameters, cv=5)
    clf.fit(X_train, y_train)

    joblib.dump(clf.best_estimator_, model_filename)
    return clf.best_estimator_

def evaluate_model(model, X_test, y_test):
    y_pred = model.predict(X_test)
    accuracy = accuracy_score(y_test, y_pred)
    print(f'<br><br>Model Accuracy: {accuracy:.2f}')
    return accuracy

def predict_profession(model, user_answers):
    predicted_profession = model.predict([user_answers])
    return predicted_profession[0]

def main():
    data = load_data('ml/scienceData.csv')
    X, y = preprocess_data(data)
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

    model_filename = 'ml/Science_model.pkl'

    if os.path.exists(model_filename):
        model = joblib.load(model_filename)
        print("Loaded model from file.")
    else:
        model = train_model(X_train, y_train, model_filename)
        print("Trained a new model and saved it to file.")

    accuracy = evaluate_model(model, X_test, y_test)
    print (accuracy)
    user_answers = sys.argv[1]
    user_answers = [float(x) for x in user_answers.split(',')]
    # user_answers = [7, 6, 1, 7, 1, 4, 3, 6,1]
    predicted_profession = predict_profession(model, user_answers)
    print(f'<br><br>Predicted Profession: {predicted_profession}')

if __name__ == "__main__":
    main()
