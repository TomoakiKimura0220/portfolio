package jp.ac.ait.k21231;


/**
 * 勇者の職業を定義するインターフェイス
 */
public interface IHeroJob {

    /**
     * 勇者の職業名を返します
     * (主にメッセージ表示で使ってください)
     * @return 職業名
     */
    String getJobName();

    /**
     * 勇者の職業個別の特殊行動の名前を返します
     * (主にメッセージ表示で使ってください)
     * @return 特殊行動名
     */
    String getSpecialAttackName();

    /**
     * 特殊行動
     * @param target 行動対象(基本はEnemyを渡すが便宜上CharacterBaseのインスタンスとする)
     * @return 攻撃結果(行動の内容に関わらず攻撃結果クラスを返す)
     */
    AttackResult specialAttack(CharacterBase target);
}
