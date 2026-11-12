import secrets
import string
import hashlib


def generate_password(length):
    if length < 4:
        raise ValueError("Password length must be at least 4.")

    characters = (
        string.ascii_letters
        + string.digits
        + string.punctuation
    )

    password = [
        secrets.choice(string.ascii_uppercase),
        secrets.choice(string.ascii_lowercase),
        secrets.choice(string.digits),
        secrets.choice(string.punctuation)
    ]

    password.extend(
        secrets.choice(characters) for _ in range(length - 4)
    )

    secrets.SystemRandom().shuffle(password)

    return "".join(password)


def calculate_hash(text):
    return hashlib.sha256(text.encode("utf-8")).hexdigest()


def main():
    print("========== Password Generator & SHA-256 Hasher ==========")

    try:
        length = int(input("Enter password length (minimum 4): "))

        if length < 4:
            print("Error: Password length must be at least 4.")
            return

        password = generate_password(length)
        password_hash = calculate_hash(password)

        print("\nGenerated Password:", password)
        print("SHA-256 Hash:", password_hash)

        text = input("\nEnter text to calculate its SHA-256 hash: ")
        text_hash = calculate_hash(text)

        print("Text SHA-256 Hash:", text_hash)

    except ValueError:
        print("Error: Please enter a valid number for password length.")


if __name__ == "__main__":
    main()