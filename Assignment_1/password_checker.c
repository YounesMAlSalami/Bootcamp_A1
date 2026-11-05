#include <stdio.h>
#include <string.h>
#include <ctype.h>

// تعريف مستويات الأمان
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

    // 1. طباعة طول كلمة المرور (حسب معايير القبول)
    printf("\n--- Password Report ---\n");
    printf("Password Length: %d characters\n", length);

    // 2. فحص الحروف باستخدام حلقة تكرار ودوال ctype.h
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

    // 3. تحديد وعرض حالة الشروط المتبقية (حسب معايير القبول)
    printf("- Uppercase letters : %s\n", upper ? "Found" : "Missing");
    printf("- Lowercase letters : %s\n", lower ? "Found" : "Missing");
    printf("- Numbers           : %s\n", digit ? "Found" : "Missing");
    printf("- Symbols           : %s\n", symbol ? "Found" : "Missing");

    int score = upper + lower + digit + symbol;

    // 4. تقييم النتيجة النهائية (التأكد من أن الطول لا يقل عن 8 وتحقق الشروط)
    PasswordStrength result;
    if (length >= 8 && score == 4)
        result = STRONG;
    else if (length >= 8 && score >= 2)
        result = MEDIUM;
    else
        result = WEAK;

    // طباعة النتيجة النهائية للمستخدم
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
    // تقييد حجم المدخلات لتجنب تجاوز الذاكرة (Buffer Overflow)
    scanf("%99s", password);

    checkPassword(password);

    return 0;
}