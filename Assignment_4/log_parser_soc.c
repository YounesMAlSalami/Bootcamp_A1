#include <stdio.h>
#include <string.h>
#include <ctype.h> // مكتبة لدعم تحويل الأحرف

// دالة مساعدة لتحويل النص بالكامل إلى حروف صغيرة (Lowercase)
void to_lower_string(char *dest, const char *src) {
    int i = 0;
    while (src[i] != '\0') {
        dest[i] = tolower((unsigned char)src[i]);
        i++;
    }
    dest[i] = '\0';
}

int main(int argc, char *argv[]) {
    if (argc != 3) {
        printf("Usage: %s <logfile> <keyword>\n", argv[0]);
        printf("Example: %s server.log failed\n", argv[0]);
        return 1;
    }

    char *filename = argv[1];
    char raw_keyword[256];
    strcpy(raw_keyword, argv[2]);

    FILE *file = fopen(filename, "r");
    if (file == NULL) {
        perror("Error: Could not open log file");
        return 1;
    }

    char line[512];
    char lower_line[512];
    char lower_keyword[256];

    // تحويل كلمة البحث الأساسية إلى حروف صغيرة لتصبح غير حساسة للحالة
    to_lower_string(lower_keyword, raw_keyword);

    int line_number = 0;
    int alert_count = 0;

    printf("\n--- SOC Log Analysis Report (Case-Insensitive) ---\n");
    printf("Target File: %s\n", filename);
    printf("Keyword Searched: %s\n------------------------------------\n", raw_keyword);

    while (fgets(line, sizeof(line), file) != NULL) {
        line_number++;

        // تحويل السطر الحالي إلى حروف صغيرة لغرض المقارنة فقط
        to_lower_string(lower_line, line);

        // البحث عن الكلمة بغض النظر عن كونها كبيراً أو صغيراً
        if (strstr(lower_line, lower_keyword) != NULL) {
            alert_count++;
            // طباعة السطر الأصلي كما هو
            printf("[Alert #%d] Line %d: %s", alert_count, line_number, line);
        }
    }

    printf("\n------------------------------------\n");
    printf("Scan Complete. Total Alerts Found: %d\n", alert_count);
    printf("------------------------------------\n");

    fclose(file);
    return 0;
}