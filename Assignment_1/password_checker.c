#include <stdio.h>
#include <string.h>
#include <ctype.h>


typedef enum
{
    WEAK,
    MEDIUM,
    STRONG
} PasswordStrength;

void checkPassword(const char password[])
{
    int upper = 0;
    int lower = 0;
    int digit = 0;
    int symbol = 0;

    int length = strlen(password);

  
    printf("\n--- Password Report ---\n");
    printf("Password Length: %d characters\n", length);

  
    for (int i = 0; i < length; i++)
    {
        unsigned char ch = password[i];

        if (isupper(ch))
            upper = 1;
        else if (islower(ch))
            lower = 1;
        else if (isdigit(ch))
            digit = 1;
        else
            symbol = 1;
    }

    
    printf("- Uppercase letters : %s\n", upper ? "Found" : "Missing");
    printf("- Lowercase letters : %s\n", lower ? "Found" : "Missing");
    printf("- Numbers           : %s\n", digit ? "Found" : "Missing");
    printf("- Symbols           : %s\n", symbol ? "Found" : "Missing");

    int score = upper + lower + digit + symbol;

    
    PasswordStrength result;
    if (length >= 8 && score == 4)
        result = STRONG;
    else if (length >= 8 && score >= 2)
        result = MEDIUM;
    else
        result = WEAK;


    printf("Final Evaluation: ");
    if (result == STRONG)
        printf("Your Password is Strong\n");
    else if (result == MEDIUM)
        printf("Your Password is Medium\n");
    else
        printf("Your Password is Weak\n");
    
    printf("-----------------------\n");
}

int main(void)
{
    char password[100];

    printf("Enter your password: ");

    scanf("%99s", password);

    checkPassword(password);

    return 0;
}
